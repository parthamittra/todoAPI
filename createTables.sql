create table users(
	id int unsigned not null auto_increment,
	username varchar(100) not null,
	password varchar(100) not null,
	firstname varchar(100),
	lastname varchar(100),
	primary key (id)
)engine=innodb;


create table lists(
	id int unsigned not null auto_increment,
	user_id int unsigned not null,
	name varchar(50) not null,
	primary key (id),
	foreign key (user_id) references users(id)
)engine=innodb;


create table items(
	id int unsigned not null auto_increment,
	list_id int unsigned not null,
	item varchar(200) not null,
	status enum('pending','complete'),
	primary key (id),
	foreign key (list_id) references lists(id)
)engine=innodb;


create table tokens(
	id int unsigned not null auto_increment,
	user_id int unsigned not null,
	token varchar(200) not null,
	primary key (id),
	foreign key (user_id) references users(id)
)engine=innodb;
