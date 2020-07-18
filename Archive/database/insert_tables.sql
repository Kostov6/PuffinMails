INSERT INTO `users` (`userID`, `username`, `password_hash`, `first_name`, `last_name`, `faculty_number`, `number_theme`, `recension_number`, `is_admin`, `ban_until`) VALUES
(1, 'dragPeev', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Драган', 'Пеевски', 12, 3, NULL, 0, NULL),
(2, 'lubtl', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Любомир', 'Тлаченски', 112, 1, NULL, 0, NULL),
(3, 'ivIv', '$2y$10$M6nTwlV3MDy0h5uWpIwlS.0.boJLvGKUwJhy7zrmkhIH8A9di0JdS', 'Иван', 'Иванов', 512, 4, NULL, 0, NULL),
(4, 'doiZl', '$2y$10$M6nTwlV3MDy0h5uWpIwlS.0.boJLvGKUwJhy7zrmkhIH8A9di0JdS', 'Дойчин', 'Златаров', 0, NULL, NULL, 1, NULL),
(5, 'minaZl', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Минаил', 'Златев', 76, 6, NULL, 0, '2020-07-14'),
(6, 'hoseto', '$2y$10$M6nTwlV3MDy0h5uWpIwlS.0.boJLvGKUwJhy7zrmkhIH8A9di0JdS', 'Хосе', 'Еспаниоло', 6585, 2, 3, 0, NULL),
(7, 'machoto', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Мачо', 'Пикчо', 8362, 7, NULL, 0, NULL),
(8, 'sasho', '$2y$10$M6nTwlV3MDy0h5uWpIwlS.0.boJLvGKUwJhy7zrmkhIH8A9di0JdS', 'Александър', 'Савчев', 62204, 58, 6, 0, '2020-07-01');

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

INSERT INTO MESSAGE(senderId,msgType,title,content,time_sent)
VALUES (1,0,"Title #1","Message #1","2020-01-01");
INSERT INTO MESSAGE(senderId,msgType,title,content,time_sent)
VALUES (2,1,"Title #2","Message #2","2020-02-02");
INSERT INTO MESSAGE(senderId,msgType,title,content,time_sent)
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