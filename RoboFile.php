<?php

/**
 * RoboFile.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product
 * @link      http://www.techdivision.com
 */

use Lurker\Event\FilesystemEvent;

use Symfony\Component\Finder\Finder;

/**
 * Defines the available build tasks.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product
 * @link      http://www.techdivision.com
 *
 * @SuppressWarnings(PHPMD)
 */
class RoboFile extends \Robo\Tasks
{

    /**
     * The build properties.
     *
     * @var array
     */
    protected $properties = array(
        'base.dir' => __DIR__,
        'src.dir' => __DIR__ . '/src',
        'dist.dir' => __DIR__ . '/dist',
        'vendor.dir' => __DIR__ . '/vendor',
        'target.dir' => __DIR__ . '/target'
    );

    /**
     * Runs the composer install command.
     *
     * @return \Robo\Result The result
     */
    public function composerInstall()
    {
        // optimize autoloader with custom path
        $this->taskComposerInstall()
             ->preferDist()
             ->optimizeAutoloader()
             ->run();
    }

    /**
     * Runs the composer update command.
     *
     * @return \Robo\Result The result
     */
    public function composerUpdate()
    {
        // optimize autoloader with custom path
        $this->taskComposerUpdate()
             ->preferDist()
             ->optimizeAutoloader()
             ->run();
    }

    /**
     * Clean up the environment for a new build.
     *
     * @return \Robo\Result The result
     */
    public function clean()
    {
        $this->taskDeleteDir($this->properties['target.dir'])->run();
    }

    /**
     * Prepare's the environment for a new build.
     *
     * @return \Robo\Result The result
     */
    public function prepare()
    {
        $this->taskFileSystemStack()
             ->mkdir($this->properties['dist.dir'])
             ->mkdir($this->properties['target.dir'])
             ->mkdir(sprintf('%s/reports', $this->properties['target.dir']))
             ->run();
    }

    /**
     * Runs the PHPMD.
     *
     * @return \Robo\Result The result
     */
    public function runMd()
    {

        // run the mess detector
        $this->_exec(
            sprintf(
                '%s/bin/phpmd %s xml phpmd.xml --reportfile %s/reports/pmd.xml --ignore-violations-on-exit',
                $this->properties['vendor.dir'],
                $this->properties['src.dir'],
                $this->properties['target.dir']
            )
        );
    }

    /**
     * Runs the PHPCPD.
     *
     * @return \Robo\Result The result
     */
    public function runCpd()
    {

        // run the copy paste detector
        $this->_exec(
            sprintf(
                '%s/bin/phpcpd --exclude Observers --log-pmd %s/reports/pmd-cpd.xml %s',
                $this->properties['vendor.dir'],
                $this->properties['target.dir'],
                $this->properties['src.dir']
            )
        );
    }

    /**
     * Runs the PHPCodeSniffer.
     *
     * @return \Robo\Result The result
     */
    public function runCs()
    {

        // run the code sniffer
        $this->_exec(
            sprintf(
                '%s/bin/phpcs -n --extensions=php --standard=phpcs.xml --report-full --report-checkstyle=%s/reports/phpcs.xml %s',
                $this->properties['vendor.dir'],
                $this->properties['target.dir'],
                $this->properties['src.dir']
            )
        );
    }

    /**
     * Runs the PHPUnit tests.
     *
     * @return \Robo\Result The result
     */
    public function runTests()
    {

        // run PHPUnit
        $this->taskPHPUnit(sprintf('%s/bin/phpunit', $this->properties['vendor.dir']))
             ->configFile('phpunit.xml')
             ->run();
    }

    /**
     * The complete build process.
     *
     * @return void
     */
    public function build()
    {

        // stop the build on first failure of a task
        $this->stopOnFail(true);

        // process the build
        $this->clean();
        $this->prepare();
        $this->runCs();
        $this->runCpd();
        $this->runMd();
        $this->runTests();
    }
}
