var app = angular.module("CarPart",[]);

app.controller('CarPartController',function ($scope,$http) {

	$scope.make = "";
	$scope.model = "";
	$scope.badge = "";
	$scope.series = "";	

	$scope.init = function () {
		$http.get('/make')
		.then(function(response) {
			
			$scope.makes = response.data.makes;
		});

		
	}
	$scope.changeMake = function () {	

		$http.get('/model?make=' + $scope.make)
		.then(function(response) {
			$scope.models=response.data.models;
			$scope.numberprices = response.data.numberprices;
		});
	}

	$scope.ChangeModel = function () {

		$http.get('/badge?make=' + $scope.make + '&model=' + $scope.model)
			.then(function(response) {
				$scope.badges=response.data.badges;
			});
	}

	$scope.ChangeBadge = function () {
		
		$http.get('/series?make=' + $scope.make + '&model=' + $scope.model + '&badge=' + $scope.badge)
			.then(function(response){
				$scope.series = response.data.series;
			});
		$scope.series = "";	
	}

	$scope.ChangeSeries = function() {
		
		$http.get('/index?make=' + $scope.make + '&model=' + $scope.model + '&badge=' + $scope.badge + '&series=' + $scope.serie)
			.then(function(response){
				$scope.numberprices = response.data.numberprices;
				 // console.log(response.data);
			});

	}

	// $scope.Show = function () {

	// 	$http.get('http://localhost:8000/index?make=' + $scope.make + '&model=' + $scope.model + '&badge=' + $scope.badge + '&series=' + $scope.serie)
	// 		.then(function(response){
	// 			$scope.numberprices = response.data.numberprices;
	// 		});
		
	// }

	$scope.hideform = true;

	$scope.Edit = function (id) {
		
		$scope.hideform = false;
		console.log($scope.id);
		$http.get('/edit/' + id)
			.then(function(response){
				
				$scope.pricenumber = response.data.pricenumber;

			});		
	}
});

app.factory('httpInterceptor', function ($q, $rootScope, $log) {

    var numLoadings = 0;

    return {
        request: function (config) {

            numLoadings++;

            // Show loader
            $rootScope.$broadcast("loader_show");
            return config || $q.when(config)

        },
        response: function (response) {

            if ((--numLoadings) === 0) {
                // Hide loader
                $rootScope.$broadcast("loader_hide");
            }

            return response || $q.when(response);

        },
        responseError: function (response) {

            if (!(--numLoadings)) {
                // Hide loader
                $rootScope.$broadcast("loader_hide");
            }

            return $q.reject(response);
        }
    };
});
app.config(function ($httpProvider) {
    $httpProvider.interceptors.push('httpInterceptor');
});
app.directive("loader", function ($rootScope) {
    return function ($scope, element) {
        $scope.$on("loader_show", function () {
            return element.show();
        });
        return $scope.$on("loader_hide", function () {
            return element.hide();
        });
    };
});


