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
			throw new CDEUnitTestFailedException('Expected: true got: ' .
				var_export($actual, true));
		}
	}

	protected function assertFalse($actual) {
		if ($actual !== false) {
			throw new CDEUnitTestFailedException('Expected: false got: ' .
				var_export($actual, true));
		}
	}
}
