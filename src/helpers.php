<?php

if (! function_exists('validator')) {

	function validator( $dataToValidate, $rules, $messages = [] ) {
		$filesystem = new Illuminate\Filesystem\Filesystem();
		$fileLoader = new \Illuminate\Translation\FileLoader( $filesystem, '' );
		$translator = new Illuminate\Translation\Translator( $fileLoader, 'en_US' );
		$factory    = new \Illuminate\Validation\Factory( $translator );

		$validator = $factory->make( $dataToValidate, $rules, $messages );

		return $validator;
	}
}