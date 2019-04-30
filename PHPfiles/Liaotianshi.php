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

/* Style the top navigation bar */
.topnav {
  overflow: hidden;
  background-color: #333;
}

/* Style the topnav links */
.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
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

/* Right column */
.rightcolumn {
  float: left;
  width: 80%;
  background-color: #f1f1f1;
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

#create_workspace:hover #create_wsp{
  display: block;
}


#create_wsp {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 12px 16px;
    z-index: 1;
}

#create_channel:hover #create_cha{
  display: block;
}


#create_cha {
  display: none;
  position: absolute;
  left: 100px;
  background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 12px 16px;
    z-index: 1;
}

#invite:hover #invite_content{
  display: block;
}


#invite_content {
  display: none;
  position: absolute;
  left: 270px;
  background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 12px 16px;
    z-index: 1;
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
  <div class="topnav">

    <div id="create_workspace">
      <a>Create Workspace</a>
      <div id="create_wsp">
        <input type="text" id="createname" placeholder="Workspace Name"><input type="submit" 
        value="create" ng-click="createNewWorkspace()">
      </div>
    </div>

    <div id="create_channel">
      <a>Create Channel</a>
      <div id="create_cha">
        <input type="text" id="createChannelName" placeholder="Channel Name"><input type="text" id="createChannelType" placeholder="Channel Type"><input type="submit" 
        value="create" ng-click="createNewChannel()">
      </div>
    </div>

    <div id="invite">
      <a>Invite</a>
      <div id="invite_content">
        <input type="text" id="invitee" placeholder="Username"><input type="submit" 
        value="Invite To Workspace" ng-click="inviteToWorkspace()"><input type="submit" 
        value="Invite To Channel" ng-click="inviteToChannel()"><input type="submit" 
        value="Have Direct" ng-click="haveDirect()">
      </div>
    </div>

    <a href="Invitations.php">Show Invitations</a>

    <a href="LoginPage.php" style="float:right">Exit</a>
  </div>

  <div class="row">

    <div class="leftcolumn">
    <table>
      WorkSpaces:
      <tr ng-repeat="x in workspaces">
        <td class="workspace" ng-click="showChannels(x.Workspace)">{{ x.Workspace }}</td>
      </tr>
    </table>
    <table>
      Channels:
      <tr ng-repeat="x in channels">
        <td class="channel" ng-click="showMessages(x.Cid)">{{ x.Channel }}</td>
      </tr>
    </table>
    </div>

    <div class="rightcolumn">
      <div class="card">

        <div class="card message">
          <div  ng-repeat="x in messages">
            <p>{{ x.Uname + ": " + x.Mcontent}}</p>
          </div>
        </div>

        <textarea id="Your Message"></textarea>
        <input type="submit" 
        value="send" ng-click="sendMessage()" style="width:100px">
      </div>
    </div>
  </div>
  <p>{{wtf}}</p>
</div>

<script>
var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope, $http) {
   $http.get("phpForWorkpspace.php")
   .then(function (response) {$scope.workspaces = response.data.records;});

   $scope.createNewWorkspace = function() {
      $http.get("phpForCreateWorkpspace.php?newWorkspace=" + document.getElementById("createname").value)
      .then(function (response) {$scope.workspaces = response.data.records;});
   }

   $scope.showChannels = function(param) {
      $http.get("phpToShowChannels.php?workspace=" + param)
      .then(function (response) {$scope.channels = response.data.records;});
   }

   $scope.showMessages = function(param) {
      $http.get("phpToShowMessages.php?cid=" + param)
      .then(function (response) {$scope.messages = response.data.records;});
   }

   $scope.createNewChannel = function() {
      $http.get("phpForCreateChannel.php?newChannel=" + document.getElementById("createChannelName").value + "&channelType=" + document.getElementById("createChannelType").value)
      .then(function (response) {$scope.channels = response.data.records;});
   }

   $scope.sendMessage = function() {
      $http.get("phpForCreateMessage.php?message=" + document.getElementById("Your Message").value)
      .then(function (response) {$scope.messages = response.data.records;});
   }

   $scope.inviteToWorkspace = function() {
      $http.get("phpForInviteWorkspace.php?invitee=" + document.getElementById("invitee").value)
      .then(function (response) {$scope.wtf = response.data;});
   }

   $scope.inviteToChannel = function() {
      $http.get("phpForInviteChannel.php?invitee=" + document.getElementById("invitee").value)
      .then(function (response) {$scope.wtf = response.data;});
   }

   $scope.haveDirect = function() {
      $http.get("phpForDirect.php?invitee=" + document.getElementById("invitee").value)
      .then(function (response) {$scope.channels = response.data.records;});
   }

});
</script>

</body>
</html>

