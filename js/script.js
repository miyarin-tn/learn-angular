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
		$scope.names = response.data;
	});
	$scope.sortBy = function(x) {
		$scope.mySort = x;
	};
	$scope.registerUser = function() {
		var user = new Object();
		user['firstname'] = $scope.firstname;
		user['lastname'] = $scope.lastname;
		user['username'] = $scope.username;
		user['password'] = $scope.password;
		if(user['firstname'] || user['lastname'] || user['username'] || user['password']) {
			$scope.names.push(user);
			$scope.showForm = true;
			$scope.showRegister = false;
		}
	};
	$scope.numEdit = '';
	$scope.editUser = function(id) {
		$scope.numEdit = id;
		console.log(id);
	};
	$scope.deleteUser = function(id) {
		$scope.names.splice(id, 1);
	};
	$scope.showForm = true;
	$scope.changeUser = function(x) {
		if (x === 'new') {
			$scope.showRegister = true;
			$scope.showForm = false;
		}
	};
});