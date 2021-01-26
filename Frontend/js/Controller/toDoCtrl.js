angular.module("toDoApp").controller("toDoCtrl", function($scope, $http) {
    var loadToDoList = function() {
        $http({
            method: 'GET',
            url: 'http://localhost/todo'
        }).then(function(response) {
            $scope.toDoList = response.data;
        });
    };

    $scope.submit = function() {
        if ($scope.description) {
            $http({
                method: 'POST',
                url: 'http://localhost/todo',
                data: { description: $scope.description }
            }).then(function(response) {
                $scope.toDoList.push(response.data);
                $scope.description = "";
            });
        }
    };

    $scope.deleteToDo = function(id) {
        $http({
            method: 'DELETE',
            url: `http://localhost/todo/${id}`
        }).then(function(response) {
            loadToDoList();
        });
    };

    loadToDoList();
});