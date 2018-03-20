angular.module('myApp', []).controller('searchName', function($scope) {
	$scope.names = [
		{firstname: 'Thinh', lastname: 'Nguyen'},
		{firstname: 'Ngoc', lastname: 'Phan'},
		{firstname: 'Trinh', lastname: 'Le'},
	];
	$scope.sortBy = function(x) {
		$scope.mySort = x;
	}
});