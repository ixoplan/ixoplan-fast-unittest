<?php

namespace Ixolit\Dislo\CDE\UnitTest;

use Ixolit\Dislo\CDE\Interfaces\FilesystemAPI;

class CDETestRunner {
	/**
	 * @var FilesystemAPI
	 */
	private $filesystemAPI;
	private $directories = [];

	/**
	 * CDETestRunner constructor.
	 *
	 * @param FilesystemAPI $filesystemAPI
	 * @param array         $directories
	 */
	public function __construct(FilesystemAPI $filesystemAPI, $directories) {
		$this->filesystemAPI = $filesystemAPI;
		$this->directories   = $directories;
	}

	public function getUnitTests() {
		foreach ($this->directories as $directory) {
			foreach ($this->filesystemAPI->listDirectory($directory) as $file) {
				if (\preg_match('/\.php$/D', $file->getName())) {
					include_once((string)$file);
				}
			}
		}

		$result = [];
		foreach (\get_declared_classes() as $class) {
			if (\in_array('Ixolit\\Dislo\\CDE\\UnitTest\\CDEUnitTest', \class_parents($class))) {
				$result[$class] = [];
				foreach (\get_class_methods($class) as $method) {
					if (preg_match('/^test/', $method)) {
						$result[$class][] = $method;
					}
				}
			}
		}
		return $result;
	}

	public function execute($testClass, $testMethod) {
		$this->getUnitTests();
		$class = new $testClass();
		try {
			$class->$testMethod();
			return 'pass';
		} catch (CDEUnitTestFailedException $e) {
			return 'fail';
		}
	}
}
