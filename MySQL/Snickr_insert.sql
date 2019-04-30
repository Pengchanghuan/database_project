use snickr;
insert into User (Uid, Uname, Uemail, Upassword, Unickname) values 
(1, "Troy", "pegasus@gg.com", 123456, "Hanzo"),
(2, "Chen", "tsugumi@gg.com", 234567, "Vegetable"),
(3, "Mao", "momo@gg.com", 345678, "Mercy"),
(4, "Jack", "codef@gg.com", 456789, "Fried Rice"),
 (5, "Stephen", "qaqyic@gg.com", 567890, "Lucio"),
 (6, "Gina", "ilovecat@gg.com", 392675, "Rein"),
 (7, "Paul", "oooo@gg.com", 384721, "Genji"),
(8, "Miho", "error@gg.com", 381911, "Zarya"),
 (9, "Kai", "pumpking@gg.com", 296654, "Ana");
 
insert into WorkSpace (Wid, Wname, Wdescription, Wtime, Wcreator) values
(1, "Company", "General workspace for the company", "2019-04-01 10:00:00", 2), 
(2, "School", "General workspace for the school", "2018-12-31 10:00:00", 8),
(3, "Apartment", "General workspace for the apartment building", "2019-01-20 10:00:00", 1),
(4, "Photography Club", "General workspace for a photography club", "2018-02-01 00:00:00", 3);

insert into WorkSpaceMember (Wid, Uid, WMtime, Wrole) values 
(1, 2, "2019-04-01 10:00:01", "Administrator"),
(1, 6, "2019-04-01 12:00:01", "Member"),
(1, 7, "2019-04-03 10:00:00", "Member"),
(1, 4, "2019-04-03 12:00:00", "Member"),
(1, 1, "2019-04-04 10:00:00", "Member"),
(3, 1, "2019-01-20 10:00:01", "Administrator"), 
(3, 2, "2019-01-20 12:00:00", "Member"),
(3, 9, "2019-01-21 10:00:00", "Member"),
(3, 5, "2019-01-21 12:00:00", "Member"),
(4, 3, "2018-02-01 00:00:01", "Administrator"), 
(4, 7, "2018-02-01 12:00:00", "Member"),
(4, 9, "2018-05-03 10:00:00", "Member"),
(4, 5, "2018-06-01 10:00:00", "Member"),
(4, 6, "2018-06-02 10:00:00", "Member"),
(2, 8, "2018-12-31 10:00:01", "Administrator");

insert into Channel (Cid, Cname, Wid, Ctype, Ctime, Ccreator) values 
(1, "Accounting", 1, "public", "2019-04-02 10:00:00", 4),
(2, "Design", 1, "private", "2019-04-02 12:00:00", 7),
(3, "MealPlan", 1, "public", "2019-04-02 09:00:00", 6),
(4, "4th Floor", 3, "private", "2019-03-01 10:00:00", 5), 
(5, "Roommate", 3, "direct", "2019-03-04 10:00:00", 2);

insert into ChannelMember (Cid, Uid, CMtime) values 
(1, 4, "2019-04-02 10:00:01"),
(1, 7, "2019-04-02 12:00:00"),
(1, 2, "2019-04-02 12:00:10"),
(2, 7, "2019-04-02 12:00:01"), 
(2, 2, "2019-04-03 10:00:00"), 
(3, 6, "2019-04-02 09:00:01"), 
(3, 7, "2019-04-03 10:00:00"), 
(3, 4, "2019-04-03 10:00:00"), 
(4, 5, "2019-03-01 10:00:01"), 
(4, 2, "2019-03-02 10:00:00"), 
(5, 2, "2019-03-04 10:00:01"), 
(5, 9, "2019-03-04 10:00:20");

insert into WorkspaceInv (Wid, AdminID, Uid, WItime) values 
(1, 2, 6, "2019-04-01 11:00:00"),
(1, 2, 7, "2019-04-02 10:00:00"),
(1, 2, 4, "2019-04-02 10:00:30"),
(1, 2, 1, "2019-04-02 10:10:00"), 
(2, 8, 1, "2019-01-01 19:00:00"), 
(3, 1, 2, "2019-01-20 11:00:00"), 
(3, 1, 9, "2019-01-20 11:00:20"), 
(3, 1, 5, "2019-01-20 12:00:00"), 
(4, 3, 7, "2018-02-01 02:00:00"), 
(4, 3, 9, "2019-03-01 10:00:00"), 
(4, 3, 5, "2019-04-01 10:00:00"), 
(4, 3, 6, "2019-05-01 10:00:00");

insert into ChannelInv (Cid, CreatorID, Uid, CItime) values 
(1, 4, 7, "2019-04-02 11:00:00"),
(1, 4, 2, "2019-04-02 11:10:00"),
(1, 4, 6, "2019-04-02 11:20:00"),
(1, 4, 1, "2019-04-02 11:30:00"), 
(2, 7, 2, "2019-04-02 13:00:00"), 
(3, 6, 7, "2019-04-02 10:00:00"), 
(3, 6, 4, "2019-04-02 10:10:00"), 
(3, 6, 1, "2019-04-02 10:30:00"), 
(3, 6, 2, "2019-04-02 10:40:00"), 
(4, 5, 2, "2019-03-01 12:00:00"), 
(5, 2, 9, "2019-03-04 10:00:10");

insert into Message (Cid, Uid, Mtime, Mcontent) values
(1, 4, "2019-04-10 10:00:00", "What's up everybody?"),
(1, 7, "2019-04-10 11:00:00", "I love perpendicular buildings."),
(1, 2, "2019-04-10 12:00:00", "Did someone just say perpendicular??"),
(2, 7, "2019-04-10 10:00:00", "How about some perpendicular reference guys?"), 
(2, 2, "2019-04-10 10:30:00", "It's a beautiful day."),
(4, 5, "2019-04-01 10:00:00", "Greetings!"),
(4, 5, "2019-04-01 11:00:00", "Justice rains from the above!"),
(4, 2, "2019-04-02 10:00:00", "I just want to say perpendicular to yall"),
(4, 5, "2019-04-04 10:00:00", "Today is perpendicular!"),
(3, 6, "2019-04-10 10:00:00", "How is that perpendicular building today?");
