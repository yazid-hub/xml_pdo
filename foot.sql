drop database if exists foot; 
create database foot; 
use foot; 

create table equipe(
idequipe int not null auto_increment primary key,
designation varchar(50),
couleur varchar(50),
division varchar(20)
);



create table joueur(
idjoueur int not null auto_increment primary key,
nom varchar(50),
prenom varchar(50),
poste varchar(50),
numero int,
idequipe int,
constraint fkteam
foreign key(idequipe) references equipe(idequipe)
);

insert into Equipe values (null,"barça","bleu","la liga");
insert into Equipe values (null,"real","blanc","la liga");



insert into joueur values(null,"messi","lionel","attaquant",10, 1);
insert into joueur values(null,"christiano","ronaldo","attaquant",7, 2);
insert into joueur values(null,"antsu","fati","attaquant",9, 1);