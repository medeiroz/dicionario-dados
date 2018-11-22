<?php

$aux_array = [
	[
		'id' => 1,
		'table' => 'companies',
		'comment' => 'Armazenará os dados sobre as empresas.',
		'columns' => [
			[
				'description' => 'id',
				'type' => 'int',
				'size' => 10,
				'nullable' => false,
				'key' => 'PK',
				'comment' => 'Identificador do registro',
			],
			[
				'description' => 'name',
				'type' => 'varchar',
				'size' => 100,
				'nullable' => false,
				'key' => '',
				'comment' => 'Nome da empresa',
			],
			[
				'description' => 'description',
				'type' => 'varchar',
				'size' => 100,
				'nullable' => false,
				'key' => '',
				'comment' => 'Descrioção da empresa',
			],
			[
				'description' => 'show_application',
				'type' => 'int',
				'size' => 10,
				'nullable' => false,
				'key' => '',
				'comment' => '(0/1) Se exibe ou não a pemissão na aplicação',
			],
			[
				'description' => 'created_at',
				'type' => 'timestamp',
				'size' => '',
				'nullable' => true,
				'key' => '',
				'comment' => 'Data de criação do registro',
			],
			[
				'description' => 'updated_at',
				'type' => 'timestamp',
				'size' => '',
				'nullable' => true,
				'key' => '',
				'comment' => 'Data da última do registro',
			],
		],
	],
];

echo json_encode($aux_array);