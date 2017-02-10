<?php

namespace Ixolit\Dislo\CDE\UnitTest;

use Ixolit\CDE\Exceptions\FileNotFoundException;
use Ixolit\CDE\Interfaces\FilesystemAPI;

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
			try {
				foreach ($this->filesystemAPI->listDirectory($directory) as $file) {
					if (\preg_match('/\.php$/D', $file->getName())) {
						include_once((string)$file);
					}
				}
			} catch (FileNotFoundException $e) {
			}
		}

		$result = array();
		foreach (\get_declared_classes() as $class) {
			$parents = \class_parents($class);
			if ($parents && \in_array('Ixolit\\Dislo\\CDE\\UnitTest\\CDEUnitTest', $parents)) {
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
		$unitTests = $this->getUnitTests();
		if (!isset($unitTests[$testClass]) || !in_array($testMethod, $unitTests[$testClass])) {
			throw new \Exception('Invalid test: ' . $testClass . '::' . $testMethod);
		}
		$class = new $testClass();
		try {
			$class->$testMethod();
			return 'pass';
		} catch (CDEUnitTestFailedException $e) {
			return 'fail';
		}
	}
}
