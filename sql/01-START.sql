DROP TABLE IF EXISTS NOTE, LINEITEM, SQUOTE, ASSOCIATE, DISCOUNT;

CREATE TABLE ASSOCIATE(
    ID                 INT               NOT NULL UNIQUE AUTO_INCREMENT,
    NAME               CHAR (32)         NOT NULL,
    UNAME              CHAR (32)         NOT NULL UNIQUE,
    PASSWD             CHAR (42)         NOT NULL,
    PRIVLEVEL          INT               NOT NULL,
    COMMISSION         FLOAT(8.2)        DEFAULT(0),
    ADDRESS            CHAR (42)         NOT NULL,

    PRIMARY KEY (ID)
);

CREATE TABLE SQUOTE(
    QID          INT      NOT NULL UNIQUE AUTO_INCREMENT,
    OWNER        INT      NOT NULL,
    EMAIL        CHAR(32) NOT NULL,
    DESCRIPT     CHAR(64),
    STATUS       CHAR(8),  #PRELIM, FINAL, SANCT

    PRIMARY KEY (QID),
    FOREIGN KEY (OWNER) REFERENCES ASSOCIATE(ID)
);

CREATE TABLE LINEITEM(
    QID             INT NOT NULL,
    PRICE           FLOAT(6.2) NOT NULL,
    DESCRIPT        CHAR(32) NOT NULL,

    PRIMARY KEY (QID, DESCRIPT),
    FOREIGN KEY (QID) REFERENCES SQUOTE(QID)
);

CREATE TABLE NOTE(
    QID INT NOT NULL,
    STATEMENT CHAR(128) NOT NULL,
    PRIMARY KEY (QID, STATEMENT)
);

CREATE TABLE DISCOUNT(
    QID        INT NOT NULL,
    AMOUNT     FLOAT(5.3) NOT NULL,
    DESCRIPT   CHAR(75) NOT NULL,
    PERCENTAGE BOOLEAN DEFAULT(TRUE),
    PRIMARY KEY (QID, AMOUNT, DESCRIPT)
);
