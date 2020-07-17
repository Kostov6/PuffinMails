
INSERT INTO USERS (username,first_name,last_name,faculty_number,password_hash,number_theme)
VALUES ("dragPeev","Драган","Пеевски",12,"asdada",101);
INSERT INTO USERS (username,first_name,last_name,faculty_number,password_hash,number_theme)
VALUES ("lubtl","Любомир","Тлаченски",112,"gkhnvbc",102);
INSERT INTO USERS (username,first_name,last_name,faculty_number,password_hash,number_theme)
VALUES ("ivIv","Иван","Иванов",512,"ghggkfhhfhf",103);
INSERT INTO USERS (username,first_name,last_name,faculty_number,password_hash,number_theme)
VALUES ("doiZl","Дойчин","Златаров",42,"kghkghkgkg",104);
INSERT INTO USERS (username,first_name,last_name,faculty_number,password_hash,number_theme)
VALUES ("minaZl","Минаил","Златев",76,"asdrutrutrada",105);
INSERT INTO USERS (username,first_name,last_name,faculty_number,password_hash,number_theme)
VALUES ("hoseto","Хосе","Еспаниоло",6585,"kghkgkghkg",106);
INSERT INTO USERS (username,first_name,last_name,faculty_number,password_hash,number_theme)
VALUES ("machoto","Мачо","Пикчо",8362,"asdafasfahdfh",107);

/*INSERT INTO USERS (first_name,last_name,faculty_number,password_hash)
VALUES ("TEST","TEST",6585,"kghkgDFGDkghkg");
*/

INSERT INTO INBOX(ownerId)
VALUES (1);
INSERT INTO INBOX(ownerId)
VALUES (2);
INSERT INTO INBOX(ownerId)
VALUES (3);
INSERT INTO INBOX(ownerId)
VALUES (4);
INSERT INTO INBOX(ownerId)
VALUES (5);
INSERT INTO INBOX(ownerId)
VALUES (6);

INSERT INTO CONTACTLIST
VALUES (1,2);
INSERT INTO CONTACTLIST
VALUES (1,3);
INSERT INTO CONTACTLIST
VALUES (2,3);

/* ---------------------------------------------- */

INSERT INTO GROUPS(leaderId)
VALUES (6);
INSERT INTO GROUPS(leaderId)
VALUES (5);

UPDATE USERS
SET member_of=1
WHERE userId=6;
UPDATE USERS
SET member_of=2
WHERE userId=5;
UPDATE USERS
SET member_of=2
WHERE userId=3;
UPDATE USERS
SET member_of=1
WHERE userId=7;

/* ---------------------------------------------- */

INSERT INTO MESSAGE(senderId,msgType,title,content,date_send)
VALUES (1,0,"Title #1","Message #1","2020-01-01");
INSERT INTO MESSAGE(senderId,msgType,title,content,date_send)
VALUES (2,1,"Title #2","Message #2","2020-02-02");
INSERT INTO MESSAGE(senderId,msgType,title,content,date_send)
VALUES (3,2,"Title #3","Message #3","2020-03-03");


INSERT INTO INBOXMESSAGES (msgId,inboxId)
VALUES (1,1);
INSERT INTO INBOXMESSAGES (msgId,inboxId)
VALUES (1,3);

INSERT INTO INBOXMESSAGES (msgId,inboxId)
VALUES (2,2);
INSERT INTO INBOXMESSAGES (msgId,inboxId)
VALUES (2,5);
INSERT INTO INBOXMESSAGES (msgId,inboxId)
VALUES (2,6);

INSERT INTO INBOXMESSAGES (msgId,inboxId)
VALUES (3,3);
INSERT INTO INBOXMESSAGES (msgId,inboxId)
VALUES (3,1);
INSERT INTO INBOXMESSAGES (msgId,inboxId)
VALUES (3,6);