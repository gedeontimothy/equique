<?php

return [
	'user' => [
		'base' => [
			'all-users' => 'All users',
			'all' => 'All',
			'account-created' => 'Account created :date',
			'stats' => [
				'placed-orders' => [
					'title' => 'Placed Orders',
					'description' => 'Les commandes passés (même ceux ayant été annulé ou rembourser) par :name'
				],
				'paided-orders' => [
					'title' => 'Paieded Orders',
					'description' => 'Les commandes ayant été payées avec succès'
				],
				'in-refundabled-orders' => [
					'title' => 'In refundabled Orders',
					'description' => 'Les commandes en attente d\'être remboursé totalement'
				],
				'money-spent' => [
					'title' => 'Money Spent',
					'description' => 'Argent total des produits ayant été payé par :name'
				],
			],
		],
		'index' => [
		],
		'show' => [
			'remove-user' => 'Remove user'
		],
	],
];