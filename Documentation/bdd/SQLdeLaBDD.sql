#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: equipment
#------------------------------------------------------------

CREATE TABLE equipment(
        ref_equip     Varchar (5) NOT NULL ,
        type_equip    Varchar (30) NOT NULL ,
        brand_equip   Varchar (30) NOT NULL ,
        name_equip    Varchar (30) NOT NULL ,
        version_equip Varchar (15) NOT NULL
	,CONSTRAINT equipment_PK PRIMARY KEY (ref_equip)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: device
#------------------------------------------------------------

CREATE TABLE device(
        id_device   Int  Auto_increment  NOT NULL ,
        isAvailable Bool NOT NULL ,
        ref_equip   Varchar (5) NOT NULL
	,CONSTRAINT device_PK PRIMARY KEY (id_device)

	,CONSTRAINT device_equipment_FK FOREIGN KEY (ref_equip) REFERENCES equipment(ref_equip)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: stock_photo
#------------------------------------------------------------

CREATE TABLE stock_photo(
        link_photo Varchar (50) NOT NULL ,
        ref_equip  Varchar (5) NOT NULL
	,CONSTRAINT stock_photo_PK PRIMARY KEY (link_photo)

	,CONSTRAINT stock_photo_equipment_FK FOREIGN KEY (ref_equip) REFERENCES equipment(ref_equip)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: borrow_info
#------------------------------------------------------------

CREATE TABLE borrow_info(
        id_borrow        Int  Auto_increment  NOT NULL ,
        startdate_borrow Date NOT NULL ,
        enddate_borrow   Date NOT NULL ,
        isActive         Bool NOT NULL
	,CONSTRAINT borrow_info_PK PRIMARY KEY (id_borrow)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: role
#------------------------------------------------------------

CREATE TABLE role(
        id_role  Int  Auto_increment  NOT NULL ,
        nom_role Varchar (50) NOT NULL
	,CONSTRAINT role_PK PRIMARY KEY (id_role)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users
#------------------------------------------------------------

CREATE TABLE users(
        id_user        Int  Auto_increment  NOT NULL ,
        matricule_user Varchar (50) NOT NULL ,
        email_user     Varchar (50) NOT NULL ,
        password_user  Varchar (50) NOT NULL ,
        name_user      Varchar (30) NOT NULL ,
        lastname_user  Varchar (30) NOT NULL ,
        phone_user     Int ,
        id_role        Int NOT NULL
	,CONSTRAINT users_PK PRIMARY KEY (id_user)

	,CONSTRAINT users_role_FK FOREIGN KEY (id_role) REFERENCES role(id_role)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: borrow
#------------------------------------------------------------

CREATE TABLE borrow(
        id_user   Int NOT NULL ,
        id_device Int NOT NULL ,
        id_borrow Int NOT NULL
	,CONSTRAINT borrow_PK PRIMARY KEY (id_user,id_device,id_borrow)

	,CONSTRAINT borrow_users_FK FOREIGN KEY (id_user) REFERENCES users(id_user)
	,CONSTRAINT borrow_device0_FK FOREIGN KEY (id_device) REFERENCES device(id_device)
	,CONSTRAINT borrow_borrow_info1_FK FOREIGN KEY (id_borrow) REFERENCES borrow_info(id_borrow)
)ENGINE=InnoDB;

