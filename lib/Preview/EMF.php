<?php

declare(strict_types=1);

// SPDX-FileCopyrightText: Daniel Kesselberg <mail@danielkesselberg.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\Files_EMFViewer\Preview;

use OC\Preview\Office;
use OCP\IBinaryFinder;
use OCP\IConfig;

class EMF extends Office {
	public function __construct(IConfig $config, IBinaryFinder $binaryFinder, array $options = []) {
		$officeBinary = $config->getSystemValue('preview_libreoffice_path', false);
		if ($officeBinary === false) {
			$officeBinary = $binaryFinder->findBinaryPath('libreoffice');
		}
		if ($officeBinary === false) {
			$officeBinary = $binaryFinder->findBinaryPath('openoffice');
		}
		$options['officeBinary'] = $officeBinary;
		parent::__construct($options);
	}

	public function getMimeType(): string {
		return '/image\/emf/';
	}
}
