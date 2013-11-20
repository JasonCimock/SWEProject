
create table univUser
(
  userId varchar2(50),  
  adminFlag char(1) Not Null,
  password varchar2(10),
  CONSTRAINT univUser_PK Primary Key(userId),  
  CONSTRAINT adminFlag_CK Check (adminFlag in ('Y', 'N'))  
);

create table univSession
(
  sessionId varchar2(32),
  userId varchar2(30),
  sessionDate date,
  CONSTRAINT PK_univSession Primary Key(sessionId),
  CONSTRAINT FK_univSession_univUser Foreign Key(userId) 
             references univUser(userId)
);

create table files
(
  serviceuser varchar2(50),  
  filepath varchar2(50),
  Status varchar2(20),
  CONSTRAINT  Primary Key(serviceuser),
  CONSTRAINT  Foreign Key(serviceuser) 
             references univUser(userId)  
);

insert into univUser values (Admin, 'Y', '12345');
commit;