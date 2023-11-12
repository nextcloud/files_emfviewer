<?php

declare(strict_types=1);

// SPDX-FileCopyrightText: Daniel Kesselberg <mail@danielkesselberg.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\Files_EMFViewer\Migration;

use OCA\Files_EMFViewer\AppInfo\Application;
use OCP\Migration\IOutput;

class RegisterMimeType extends MimeTypeMigration {
	public function getName() {
		return 'Register MIME type for "image/emf"';
	}

	public function run(IOutput $output) {
		$output->info('Registering the mimetype...');

		// Register the mime type for existing files
		$this->registerForExistingFiles();

		// Register the mime type for new files
		$this->registerForNewFiles();

		$output->info('The mimetype was successfully registered.');
	}

	private function registerForExistingFiles() {
		$mimeTypeId = $this->mimeTypeLoader->getId('image/emf');
		$this->mimeTypeLoader->updateFilecache('emf', $mimeTypeId);
	}

	private function registerForNewFiles() {
		$mapping = ['emf' => ['image/emf']];
		$mappingFile = $this->getMappingFile();
		$added = true;

		if (file_exists($mappingFile)) {
			try {
				$existingMapping = json_decode(file_get_contents($mappingFile), true, 512, JSON_THROW_ON_ERROR);
				if (is_array($existingMapping)) {
					$mapping = array_merge($existingMapping, $mapping);
					$added = array_key_exists('emf', $existingMapping);
				}
			} catch (\JsonException) {
				// fail to read an existing mimetypemapping.
			}
		}

		file_put_contents($mappingFile, json_encode($mapping, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

		if ($added) {
			$this->config->setAppValue(Application::APP_ID, self::ADDED_MIMETYPEMAPPING, 'yes');
		}
	}
}
