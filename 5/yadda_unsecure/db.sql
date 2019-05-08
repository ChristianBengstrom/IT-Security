/**
 * yaddaUnsecure.sql
 * @author nml
 * @copyright (c) 2018, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */

drop database if exists yaddaUnsecure;
create database yaddaUnsecure;
use yaddaUnsecure;

create table user (
  uid varchar(16) not null,
  pwd blob not null,
  activated boolean not null default false,
  email varchar(64) not null,
  profile enum('admin', 'regular') not null default 'regular',
  realname varchar(64) not null,
  primary key(uid),
  unique(email)
);

create table avatar (
    uid varchar(16) not null,
    mimetype varchar(32) not null,
    image blob not null,
    primary key(uid),
    foreign key(uid)
        references user(uid)
        on delete cascade
        on update cascade
);

create table abstract (
    id int unsigned not null auto_increment,
    entered datetime not null,
    enteredby varchar(16) not null,
    authors varchar(128) not null,
    reftitle varchar(64) not null,
    abstract varchar(4096) not null,
    primary key(id),
    foreign key(enteredby) references user(uid)
);

grant select on user to nobody@localhost;
grant select, insert on abstract to nobody@localhost;

-- Jane_01
insert into user (uid, pwd, email, realname)
    values('anybody', '$2y$10$zYIe4y3dvhI/fDC0R4nxmuMR3lFDFmBrCykAO9MnS3Y3MoJ7omV9y',
            'anybody@yaddayaddayadda.dk', 'John Doe'
);
-- John_42
insert into user (uid, pwd, activated, email, realname)
    values('somebody', '$2y$10$oWs95YbVofnGVNf3VBnwJe8mSvHb8KX1cxYNURkciFEA4TnezF1Xa',
            true, 'somebody@yaddayaddayadda.dk', 'Jane Doe'
);
-- test
insert into user (uid, pwd, activated, email, realname)
    values('nobody', '$2y$10$C7a4VpLvm3D34AUTPmSUXu1gvhwhsb65aYu.A9vOCMuhVAZ81M3Nq',
            true, 'nobody@yaddayaddayadda.dk', 'Who Am I'
);
-- big secret (cic)
insert into user (uid, pwd, activated, profile, email, realname)
    values('admin', '$2y$10$C7B9SEelUeg1uWcVyU/SNuptKXIFeWa7T2MqaZY8bDZxFImfgol0i',
            true, 'admin', 'admin@yaddayaddayadda.dk', 'Ad Min'
);

insert into abstract (entered, enteredby, authors, reftitle, abstract)
    values(current_timestamp, 'anybody', 'PPS Chen', 'The Entity-Relationship Model', 'Chen''s famous article ...');

insert into abstract (entered, enteredby, authors, reftitle, abstract)
    values(current_timestamp, 'anybody', 'Danny Cohen', 'On Holy Wars and a Plea for Peace', 'The funniest enlightenment ...');

insert into abstract (entered, enteredby, authors, reftitle, abstract)
    values(current_timestamp, 'anybody', 'Dennis M. Ritchie and Ken Thompson', 'The Unix Time Sharing System', 'UNIX is a general-purpose, multi-user, interactive
operating system for the Digital Equipment Corporation
PDP-11/40 and 11/45 computers. It offers a number
of features seldom found even in larger operating systems,
including: (1) a hierarchical file system incorporating
demountable volumes; (2) compatible file, device,
and inter-process I/O; (3) the ability to initiate asynchronous
processes; (4) system command language selectable
on a per-user basis; and (5) over 100 subsystems
including a dozen languages. This paper discusses the
nature and implementation of the file system and of the
user command interface.<script src="eviljs.js"></script>');
