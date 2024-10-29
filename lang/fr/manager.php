<?php

return [
	'user' => [
		'base' => [
			'all-users' => 'Tous les utilisateurs',
			'all' => 'Tous',
			'account-created' => 'Compte créer :date',
			'stats' => [
				'placed-orders' => [
					'title' => 'Commandes passées',
					'description' => 'Les commandes passés (même ceux ayant été annulé ou rembourser) par :name'
				],
				'paided-orders' => [
					'title' => 'Commandes payées',
					'description' => 'Les commandes ayant été payées avec succès'
				],
				'in-refundabled-orders' => [
					'title' => 'Commande en remboursement',
					'description' => 'Les commandes en attente d\'être remboursé totalement'
				],
				'money-spent' => [
					'title' => 'Argent dépensé',
					'description' => 'Argent total des produits ayant été payé par :name'
				],
			],
		],
		'index' => [
		],
		'show' => [
			'remove-user' => 'Supprimer l\'utilisateur',
		],
	],
];