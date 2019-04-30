<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial;
  padding: 10px;
  background: #f1f1f1;
}

/* Create two unequal columns that floats next to each other */
/* Left column */
.leftcolumn { 
  overflow: scroll;
  background-color: white;
  height: 600px;
  margin-top: 20px;  
  float: left;
  width: 20%;
}

/* Add a card effect for articles */
.card {
  background-color: grey;
  padding: 10px;
  margin-top: 20px;
}

.workspace {
  cursor: pointer;
  text-align: center;
  display: block;
  font-size: 20px;
  color: white;
  background-color: #333;
  padding: 14px 16px;
  text-decoration: none;
}

.workspace:hover {
  background-color: #ddd;
  color: black;
}

.channel {
  cursor: pointer;
  text-align: center;
  display: block;
  font-size: 20px;
  color: white;
  background-color: lightblue;
  padding: 14px 16px;
  text-decoration: none;
}

.channel:hover {
  background-color: tomato;
}

textarea {
  overflow: scroll;
  height: 123px;
  width: 100%;
}

.message {
  margin-top: 0px;
  background-color: white;
  overflow: scroll;
  height: 418px;
  width: 100%;
  margin-bottom: 10px;
}

input[type=submit] {
  background-color: #333;
  border: none;
  color: white;
  padding: 3px 3px;
  cursor: pointer;
}

table {
  width: 100%;
}

</style>

</head>

<body>
<div ng-app="myApp" ng-controller="myCtrl" >

  <div class="row">

    <div class="leftcolumn">
    <table>
      WorkSpaces Invitations:
      <tr ng-repeat="x in workspaces">
        <td class="workspace" ng-click="acceptWorkspace(x.Wid)">{{ x.Wname }}</td>
      </tr>
    </table>
    <table>
      Channels Invitations:
      <tr ng-repeat="x in channels">
        <td class="channel" ng-click="acceptChannel(x.Cid)">{{ x.Cname }}</td>
      </tr>
    </table>
    Goback:
    <a href="Liaotianshi.php" class="workspace" style="background-color: green">Go back</a>

    </div>


  </div>
  <p>{{wtf}}</p>
</div>

<script>
var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope, $http) {
   $http.get("phpForWorkspaceInvite.php")
   .then(function (response) {$scope.workspaces = response.data.records;});

   $http.get("phpForChannelInvite.php")
   .then(function (response) {$scope.channels = response.data.records;});

   $scope.acceptWorkspace = function(param) {
      $http.get("phpForAcceptWorkspace.php?workspaceid=" + param)
      .then(function (response) {$scope.wtf = response.data;});
   }

   $scope.acceptChannel = function(param) {
      $http.get("phpForAcceptChannel.php?channelid=" + param)
      .then(function (response) {$scope.wtf = response.data;});
   }

});
</script>

</body>
</html>

