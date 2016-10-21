<?php

namespace Ixolit\Dislo\CDE\UnitTest;

abstract class CDEUnitTest {
	protected function assertEquals($expected, $actual) {
		if ($expected != $actual) {
			throw new CDEUnitTestFailedException('Expected: ' . var_export($expected, true) . ' got: ' .
				var_export($actual, true));
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
