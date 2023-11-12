<?php

declare(strict_types=1);

// SPDX-FileCopyrightText: Daniel Kesselberg <mail@danielkesselberg.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\Files_EMFViewer\Migration;

use OCP\Files\IMimeTypeLoader;
use OCP\IConfig;
use OCP\Migration\IRepairStep;

abstract class MimeTypeMigration implements IRepairStep {
	public const CUSTOM_MIMETYPEMAPPING = 'mimetypemapping.json';
	public const ADDED_MIMETYPEMAPPING = 'added_emf_mimetypemapping';

	protected $mimeTypeLoader;
	protected $config;

	public function __construct(IMimeTypeLoader $mimeTypeLoader, IConfig $config) {
		$this->mimeTypeLoader = $mimeTypeLoader;
		$this->config = $config;
	}

	public function getMappingFile(): string {
		return \OC::$configDir . self::CUSTOM_MIMETYPEMAPPING;
	}
}
