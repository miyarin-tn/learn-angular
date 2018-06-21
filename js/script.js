angular.module('myApp', ['ngRoute']).config(function($routeProvider, $locationProvider) {
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
	$locationProvider.html5Mode({
		enabled: true,
		requireBase: false
	});
}).controller('alterUser', function($scope, $http) {
	$http.get('api/users').then(function(response) {
		$scope.users = response.data;
	});
	$scope.sortBy = function(x) {
		$scope.mySort = x;
	};
	$scope.registerUser = function() {
		var info = {
			"firstname": $scope.firstname,
			"lastname": $scope.lastname,
			"username": $scope.username,
			"password": $scope.password
		};
		$http({
			url: 'php/person.php',
			method: 'post',
			headers: {
				'Content-Type': 'application/json'
			},
			data: JSON.stringify(info)
		}).then(function(response) {
			$scope.users = response.data;
		});
		$scope.showRegister = false;
	};
	$scope.editUser = function(user) {
		user.boolEdit = true;
		user.backup = angular.copy(user);
	};
	$scope.saveUser = function(user, id) {
		delete user.backup;
		var info = {
			"firstname": user.firstname,
			"lastname": user.lastname,
			"username": user.username,
			"password": user.password
		}
		$http({
			url: 'api/users/' + id,
			method: 'PUT',
			headers: {
				'Content-Type': 'application/json'
			},
			data: JSON.stringify(info)
		}).then(function(response) {
			$scope.users = response.data;
		});
		user.boolEdit = false;
	};
	$scope.deleteUser = function(id) {
		$http({
			url: 'api/users/' + id,
			method: 'DELETE'
		}).then(function(response) {
			$scope.users = response.data;
		});
	};
	$scope.cancelChange = function(user, index) {
		user = angular.copy(user.backup);
		delete user.backup;
		$scope.users[index] = user;
		user.boolEdit = false;
	};
	$scope.showForm = true;
	$scope.createUser = function() {
		$scope.showRegister = true;
		$scope.firstname = '';
		$scope.lastname = '';
		$scope.username = '';
		$scope.password = '';
	};
	$scope.cancelRegister = function() {
		$scope.showRegister = false;
	};
});
