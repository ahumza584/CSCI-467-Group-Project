#Example data 1
INSERT INTO ASSOCIATE (ID, NAME, UNAME, PASSWD, ADDRESS, PRIVLEVEL)
VALUES
(1, 'ROGER'    , 'Rog21', 'ROGER\'S PW' , 'ROGER\'S ADDR', 0),
(2, 'CATHERINE', 'Cat22', 'Cathy\'S PW' , 'Cathy\'S ADDR', 0),
(3, 'Mike'     , 'Mik23', 'Mike\'S PW'  , 'Mike\'S ADDR' , 0),
(4, 'David'    , 'Dav24', 'David\'S PW' , 'DAVID\'S ADDR', 5),
(5, 'LORA'     , 'Lor25', 'Lora\'S PW'  , 'LORA\'S ADDR', 0)
;

#example order 1
INSERT INTO SQUOTE (QID, OWNER, EMAIL, DESCRIPT, STATUS, CUSTOMERID)
VALUES
(1, 1, 'Zip2@CMAIL.COM', 'Various internal Service', 'PRELIM', 0),
(2, 2, 'Getsmrt12@cc.co', 'assistance with primary project', 'FINAL', 1),
(3, 1, 'silD@yahoo.corp', 'Service on project 9', 'FINAL', 2),
(4, 3, 'bigone@cmail.co', 'A big one', 'SANCT', 3)
;

insert into LINEITEM (QID, PRICE, DESCRIPT)
VALUES
(1, 25.56, 'Component 1'),
(1, 66.83, 'Component 2'),
(1, 12.83, 'Level Charge'),
(2, 12.99, 'Substantial Aid'),
(2,  4.12, 'inSubstantial Aid'),
(4, 48.00, 'Compoeent fee'),
(4, 16.12, 'Secondary fee')
;

insert into NOTE (QID, STATEMENT)
VALUES
(1, 'Test Comment on Roger\'s first order'),
(2, 'Catherine\'s order tells me we need longer fields.'),
(2, 'Seems good otherwise'),
(3, 'This order is empty.'),
(4, 'This order tests negative discounts.')
;

INSERT INTO DISCOUNT (QID, DESCRIPT, AMOUNT)
VALUES
(2, 'example discount 1', .34),
(3, 'example discount 2', .34)
;

INSERT INTO DISCOUNT (QID, DESCRIPT, AMOUNT, PERCENTAGE)
VALUES
(4, 'raw discount', 2.45, false)
;
