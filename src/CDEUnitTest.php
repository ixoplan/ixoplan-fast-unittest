<?php

namespace Ixolit\Dislo\CDE\UnitTest;

abstract class CDEUnitTest {
	protected function assertEquals($expected, $actual) {
		if ($expected != $actual) {
			throw new CDEUnitTestFailedException();
		}
	}

	protected function assertTrue($actual) {
		if ($actual !== true) {
			throw new CDEUnitTestFailedException();
		}
	}

	protected function assertFalse($actual) {
		if ($actual !== false) {
			throw new CDEUnitTestFailedException();
		}
	}
}
