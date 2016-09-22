<?php

namespace Ixolit\Dislo\CDE\UnitTest;

abstract class CDEUnitTest {
	protected function fail($message = '') {
		throw new CDEUnitTestFailedException($message);
	}

	protected function assertEquals($expected, $actual, $message = '') {
		if ($expected != $actual) {
			if (!$message) {
				$message = 'Failed asserting that ' . \var_export($actual, true) . ' is equal to ' .
					\var_export($expected, true);
			}
			$this->fail($message);
		}
	}

	protected function assertTrue($actual) {
		if ($actual !== true) {
			$this->fail();
		}
	}

	protected function assertFalse($actual) {
		if ($actual !== false) {
			$this->fail();
		}
	}
}
