<?php

namespace Ixolit\Dislo\CDE\UnitTest;

use Ixolit\Dislo\CDE\Interfaces\RequestAPI;use Ixolit\Dislo\CDE\Interfaces\ResponseAPI;

class WebTestRunner extends CDETestRunner {
	public function handleRequest(RequestAPI $requestAPI, ResponseAPI $responseAPI) {
		$responseAPI->setStatusCode(200);
		if (\array_key_exists('test', $requestAPI->getRequestParameters())) {
			$test = \explode('::', $requestAPI->getRequestParameters()['test']);
			echo $this->execute($test[0], $test[1]);
		} else {
			?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>CDE unit tests</title>
		<meta name="HandheldFriendly" content="true" />
		<meta name="format-detection" content="telephone=no" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<style>
			table, tr, th, td {
				border: 1px solid #777;
				border-collapse: collapse;
				padding:20px;
			}
		</style>
	</head>
	<body>
		<table>
			<tbody>
				<?php foreach ($this->getUnitTests() as $className => $methods) :?>
					<tr>
						<th colspan="2"><?=\html($className)?></th>
					</tr>
					<?php foreach ($methods as $method) : ?>
						<tr class="unittest" data-class="<?=\html($className)?>" data-method="<?=\html($method)?>">
							<td><?=\html($method)?></td>
							<td class="unittest-result"></td>
						</tr>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<script>
			var unitTests = document.getElementsByClassName('unittest');
			var queue = [];
			for (var i in unitTests) {
				if (unitTests.hasOwnProperty(i)) {
					var unitTest      = unitTests[i];
					var className     = unitTest.dataset.class;
					var methodName    = unitTest.dataset.method;
					var resultElement = unitTest.getElementsByClassName('unittest-result')[0];
					queue.push({'className': className, 'methodName': methodName, 'resultElement': resultElement});
				}
			}

			var processNextTest = function () {
				if (queue.length > 0) {
					test = queue.shift();
					var xhr = new XMLHttpRequest();
					xhr.onreadystatechange = function () {
						if (this.readyState == 4 && this.status == 200) {
							test.resultElement.innerText = xhr.responseText;
							processNextTest();
						}
					};
					xhr.open('GET', '?test=' + encodeURIComponent(test.className + '::' + test.methodName), true);
					xhr.send();
				}
			};

			processNextTest();
		</script>
	</body>
</html><?php
		}
	}
}