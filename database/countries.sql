BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "countries" (
	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	"name"	TEXT NOT NULL UNIQUE,
	"code"	TEXT NOT NULL UNIQUE,
	"flag"	NUMERIC,
	"voter_name"	TEXT,
	"votes"	TEXT,
	"voting_complete"	INTEGER DEFAULT 0,
	"song_name"	TEXT DEFAULT 'Song name',
	"song_seq"	INTEGER DEFAULT 0,
	"votable"	INTEGER DEFAULT 0
);
INSERT INTO "countries" VALUES (1,'France','123','FR','Geoff Clayton',NULL,0,'I Get By With a Little Help From My Friends',1,1);
INSERT INTO "countries" VALUES (2,'Switzerland','456','SZ','Clare O''Brien',NULL,0,'Mr Blue Sky',3,1);
INSERT INTO "countries" VALUES (3,'Poland','789','PL','Paul Soulsby','["6","5","1","2"]',1,'Duel',2,1);
INSERT INTO "countries" VALUES (4,'Africa','012','AF','Isla Clayton',NULL,0,NULL,NULL,0);
INSERT INTO "countries" VALUES (5,'Italy','qwe','IT','Phil Oakey','["1","3","2","6"]',1,'Song name',4,1);
INSERT INTO "countries" VALUES (6,'Croatia','ryt','CR','Jeff Drummond-Hay',NULL,0,'Song name',5,1);
COMMIT;
