var app = angular.module("CarPart",[]);

app.controller('CarPartController',function ($scope,$http) {

	$scope.make = "";
	$scope.model = "";
	$scope.badge = "";
	$scope.series = "";
	$scope.keywords = "";
	$scope.numberprices = "";
	$scope.Search = "";

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
		$scope.Search = "";
		$scope.SearchPartNumber = true;
		$scope.CarPartNumber = false;

	}

	$scope.ChangeModel = function () {

		$http.get('/series?make=' + $scope.make + '&model=' + $scope.model)
			.then(function(response) {
				$scope.series=response.data.series;
			});
		$scope.Search = "";
		$scope.numberprices = '';
		$scope.SearchPartNumber = true;
		$scope.CarPartNumber = false;
	}

	$scope.ChangeSeries = function() {
		$http.get('/badge?make=' + $scope.make + '&model=' + $scope.model + '&series=' + $scope.serie)
				.then(function(response){
					$scope.badges = response.data.badges;
				});
		$scope.Search = "";
		$scope.numberprices = '';
		$scope.SearchPartNumber = true;
		$scope.CarPartNumber = false;
	}

	$scope.ChangeBadge = function () {
		$http.get('/index?make=' + $scope.make + '&model=' + $scope.model + '&series=' + $scope.serie + '&badge=' + $scope.badge)
		.then(function(response){
			$scope.numberprices = response.data.numberprices;
			// console.log(response.data);
		});
		$scope.Search = "";
		$scope.numberprices = '';
		$scope.SearchPartNumber = true;
		$scope.CarPartNumber = false;
	}
	$scope.SearchPartNumber = true;
	$scope.Show = function () {
		$scope.make = $scope.make ? $scope.make : '';
		$scope.model = $scope.model ? $scope.model : '';
		$scope.serie = $scope.serie ? $scope.serie : '';
		$scope.badge = $scope.badge ? $scope.badge : '';
		$http.get('/index?make=' + $scope.make + '&model=' + $scope.model + '&badge=' + $scope.badge + '&series=' + $scope.serie)
					.then(function(response){
						$scope.numberprices = response.data.numberprices;
					});
		$scope.SearchPartNumber = true;
		$scope.CarPartNumber = false;
		$scope.Search = '';
	}

	$scope.search = function () {
		if($scope.Search == "")
		{
			$scope.SearchPartNumber = false;
			$scope.CarPartNumber = true;
			$scope.keywords = "";
		}
		else {
		$http.get('/search?search=' + $scope.Search)
			.then(function(response) {
				$scope.keywords = response.data.search;
		});
		$scope.CarPartNumber = true;
		$scope.SearchPartNumber = false;
		}
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


