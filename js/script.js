angular.module('myApp', []).controller('searchName', function($scope, $http) {
	$http.get('json/person.json').then(function(response) {
		$scope.names = response.data;
	});
	$scope.sortBy = function(x) {
		$scope.mySort = x;
	}
});