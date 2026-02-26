"use strict";

var mainModule = angular.module("wizbif.main", [
	"wizbif.alert",
	"wizbif.database"
]);

mainModule.constant("authSets", {
	reviewer: {
		key: "statusID",
		values: ["0", "1", "2", "4", "5"]
	},
	member: {
		key: "statusID",
		values: ["0", "1", "2", "4"]
	},
	seniorStaff: {
		key: "positionID",
		values: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "13"]
	},
	musicDirector: {
		key: "positionID",
		values: ["0", "1", "2", "3", "8", "13", "14", "17", "18", "19", "20", "22"]
	}
});

mainModule.controller("MainCtrl", ["$scope", "alert", "db", "authSets", function($scope, alert, db, authSets, $rootScope) {
	$scope.positions = db.getDefs("positions");
	$scope.user = {};
	$scope.auth = {};
	$scope.alert = alert;

	var getUser = function() {
		db.User.get().then(function(user) {
			$scope.user = user;

			$scope.auth = _.mapValues(authSets, function(set) {
				return set.values.indexOf(user[set.key]) !== -1;
			});
		}, function() {
			$scope.user = null;
		});
	};

	$scope.logout = function() {
		if ($rootScope.showID) {
			alert("You must sign ogg before logging out.");
			return;
		}
	}

	// initialize
	getUser();
}]);
