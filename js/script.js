angular.module('myApp', ['ngRoute']).config(function($routeProvider) {
	$routeProvider
	.when('/', {
		templateUrl: 'htm/home.htm',
	})
	.when('/link', {
		template: 'Link'
	})
	.when('/child', {
		template: 'Child'
	});
}).controller('alterUser', function($scope, $http) {
	$http.get('php/person.php').then(function(response) {
		$scope.users = response.data;
	});
	$scope.sortBy = function(x) {
		$scope.mySort = x;
	};
	$scope.registerUser = function() {
		$http({
			url: 'php/person.php',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: 'action=register&firstname=' + $scope.firstname + '&lastname=' + $scope.lastname + '&username=' + $scope.username + '&password=' + $scope.password
		}).then(function(response) {
			$scope.users = response.data;
		});
		$scope.showRegister = false;
	};
	$scope.editUser = function(user) {
		user.boolEdit = true;
	};
	$scope.saveUser = function(user, id) {
		$http({
			url: 'php/person.php',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: 'action=edit&id=' + id + '&firstname=' + user.firstname + '&lastname=' + user.lastname + '&username=' + user.username + '&password=' + user.password
		}).then(function(response) {
			$scope.users = response.data;
			console.log(response.data);
		});
		user.boolEdit = false;
	};
	$scope.deleteUser = function(id) {
		$http({
			url: 'php/person.php',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: 'action=delete&id=' + id
		}).then(function(response) {
			$scope.users = response.data;
		});
	};
	$scope.cancelUser = function(user) {
		user.boolEdit = false;
	};
	$scope.showForm = true;
	$scope.createUser = function() {
		$scope.showRegister = true;
	};
});