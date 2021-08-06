<?php
declare(strict_types=0);

use PHPUnit\Framework\TestCase;
use WPPackageParser\Parser;

final class ParseTest extends TestCase
{
	protected function getReadmeExampleData()
	{
		return [
			'name' => 'Test Plugin',
			'contributors' => ['capevace'],
			'donate' => '',
			'tags' => ['one', 'two'],
			'requires' => '3.8',
			'tested' => '4.9',
			'stable' => '2.0.0',
			'short_description' => 'Plugin short description.',
			'sections' => [
    			'Description' => 'Description here.',
    			'Installation' => 'Installation here.',
    			'Frequently Asked Questions' => "= Question =\n\nAnswer\n\n= Question 2 =\n\nAnswer 2",
    			'Screenshots' => "1. WooCommerce Germanized Settings",
    			'Changelog' => "= 2.0.0 =\n* Improvement\n\n= 1.0.0 =\n* Initial Version",
    			'Upgrade Notice' => "= 2.0.0 =\nUpgrade Notice"
    		]
		];
	}

    public function testDoesParsePlugin()
    {
    	$filepath = __DIR__ . '/resources/test-plugin.zip';
		$parser = new Parser();
    	$result = $parser->parse($filepath);
    	$this->assertEquals($result, [
    		'header' => [
    			'Name' => 'Test Plugin',
    			'Plugin URI'=> 'https://testplugin.com',
			    'Version'=> '1.5.1',
			    'Description' => 'A parser test plugin.',
			    'Author' => 'Capevace',
			    'Author URI' => 'https://github.com/Capevace',
			    'Text Domain' => 'test-plugin-domain',
			    'Domain Path' => '',
			    'Network' => false,
			    'Title' => 'Test Plugin',
				'Requires PHP' => '7.2',
				'Requires at least' => '3.8',
				'Tested up to' => '4.9'
			],
    		'readme' => $this->getReadmeExampleData(),
    		'pluginFile' => 'test-plugin/test-plugin.php',
    		'stylesheet' => null,
    		'type' => 'plugin'
    	]);
    }

    public function testDoesParseTheme()
    {
    	$filepath = __DIR__ . '/resources/test-theme.zip';
		$parser = new Parser();
    	$result = $parser->parse($filepath);
    	
    	$this->assertEquals($result, [
    		'header' => [
    			'Name' => 'Test Theme',
    			'ThemeURI'=> 'https://testtheme.com',
			    'Version'=> '1.5.1',
			    'Description' => 'A parser test theme.',
			    'Author' => 'Capevace',
			    'AuthorURI' => 'https://github.com/Capevace',
			    'TextDomain' => 'test-theme-domain',
			    'DomainPath' => '',
			    'Template' => '',
			    'Status' => '',
			    'DetailsURI' => '',
			    'Tags' => ['one', 'two'],
 			],
    		'readme' => $this->getReadmeExampleData(),
    		'pluginFile' => null,
    		'stylesheet' => 'test-theme/style.css',
    		'type' => 'theme'
    	]);
    }
}

