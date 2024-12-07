drop database if exists Cineshop;
create database Cineshop;
use Cineshop;
create table Utilisateur
(
    id_utilisateur int primary key auto_increment,
    nom            varchar(100) not null,
    prenom         varchar(100),
    email          varchar(255) not null unique,
    telephone      varchar(20),
    id_role        int,

    mot_de_passe   text         not null


);

create table Role
(
    id_role     int primary key auto_increment,
    description varchar(100) not null

);

create table Adresse
(
    id_adresse  int primary key auto_increment,
    rue         varchar(100) not null,
    ville       varchar(100) not null,
    code_postal varchar(10)  not null,
    province    varchar(100) not null,
    defaut      int
);

create table AdresseUtilisateur
(
    id_utilisateur int,
    id_adresse     int
);

create table Phone
(
    id_Phone            int auto_increment primary key,
    nom                varchar(100) not null,
    prix               varchar(10)  not null,
    description        text,
    courte_description varchar(255),
    quantite           int
);

create table Image
(
    id_image     int primary key auto_increment,
    id_Phone      int,
    chemin_image text
);

create table PhoneCommande
(
    id_Phone     int,
    id_commande int,
    quantite    int
);

create table Commande
(
    id_commande    int primary key auto_increment,
    quantite       int,
    prix           varchar(10),
    statut         varchar(50),
    date_creation  date,
    id_utilisateur int,
    mode_paiement  varchar(50)

);

# relation
alter table AdresseUtilisateur
    add constraint fk_adresse_utilisateur
        foreign key (id_adresse) references Adresse (id_adresse)
            on update cascade,
    add constraint fk_utilisateur_adresse
        foreign key (id_utilisateur) references Utilisateur (id_utilisateur)
            on delete cascade on update cascade;

alter table PhoneCommande
    add constraint fk_Phone_commande
        foreign key (id_Phone) references Phone (id_Phone),
    add constraint fk_commande_Phone
        foreign key (id_commande) references Commande (id_commande);

alter table Image
    add constraint fk_image_Phone
        foreign key (id_Phone) references Phone (id_Phone);

alter table Utilisateur
    add constraint fk_role_utilisateur
        foreign key (id_role) references Role (id_role);

insert into Role(description) value ('admin'),('client');


