drop database if exists snickr;
create database snickr;
use snickr;
create table User (
	Uid int auto_increment primary key,
	Uname varchar(20),
	Uemail varchar(20),
	Upassword varchar(20),
	Unickname varchar(20)
);

create table Workspace (
	Wid int auto_increment primary key,
	Wname varchar(20),
	Wdescription varchar(50),
	Wtime datetime,
	Wcreator int,
	foreign key (Wcreator) references User(Uid) on delete cascade
);

create table WorkspaceMember (
	Wid int,
	Uid int,
	WMtime datetime,
	Wrole varchar(20),
	primary key (Wid, Uid),
	foreign key (Wid) references Workspace(Wid) on delete cascade,
	foreign key (Uid) references User(Uid) on delete cascade
);

create table Channel (
	Cid int auto_increment primary key,
	Cname varchar(20),
	Wid int,
	Ctype varchar(20),
	Ctime datetime,
	Ccreator int,
	foreign key (Wid) references Workspace(Wid) on delete cascade,
	foreign key (Ccreator) references User(Uid) on delete cascade
);

create table ChannelMember (
	Cid int,
	Uid int,
	CMtime datetime,
	primary key (Cid, Uid),
	foreign key (Cid) references Channel(Cid) on delete cascade,
	foreign key (Uid) references User(Uid) on delete cascade
);

create table Message (
	Cid int,
	Uid int,
	Mtime datetime,
	Mcontent varchar(100),
	primary key (Cid, Uid, Mtime),
	foreign key (Cid) references Channel(Cid),
	foreign key (Uid) references User(Uid)
);

create table WorkspaceInv (
	Wid int,
	AdminID int,
	Uid int,
	WItime datetime,
	primary key (Wid,AdminID,Uid,WItime),
	foreign key (Wid) references Workspace(Wid),
	foreign key (AdminID) references User(Uid),
	foreign key (Uid) references User(Uid)
);

create table ChannelInv (
	Cid int,
	CreatorID int,
	Uid int,
	CItime datetime,
	primary key (Cid,CreatorID,Uid,CItime),
	foreign key (Cid) references Channel(Cid),
	foreign key (CreatorID) references User(Uid),
	foreign key (Uid) references User(Uid)
);










