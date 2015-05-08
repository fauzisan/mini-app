/**
 * Created by akbar on 08.05.15.
 */

function AppControl($scope, $http, $templateCache){
    $scope.showJadwal = function(action){
        $http({method: 'GET', url: './src/ApiController.php?action='+action, cache: $templateCache}).
            sucess(function(data, status, headers, config){
                $scope.apps = data;
            }).
            error(function(data, status, headers, config){
                $scope.apps = data || "Request Failed";
                $scope.status = status;
            });
    }
}

AppControl.$inject = ['$scope', '$http', '$templateCache'];