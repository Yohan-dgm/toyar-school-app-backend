/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v1 
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 06/12/2024 14:50:45
*/

-- ----------------------------
-- Sequence structure for user_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."user_id_seq";
CREATE SEQUENCE "public"."user_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS "public"."user";
CREATE TABLE "public"."user" (
  "id" int8 NOT NULL DEFAULT nextval('user_id_seq'::regclass),
  "full_name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "username" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "email_verified_at" timestamp(0),
  "password" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "remember_token" varchar(100) COLLATE "pg_catalog"."default",
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "created_by" int8,
  "update_by" int8
)
;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO "public"."user" VALUES (1, 'Sevwandi Lanka Kankanamge', 'Sevwandi', 'Sevwandi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (2, 'Wasala Tanthrige Noyeli Hansika Perera', 'Noyeli', 'Noyeli@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (3, 'Sirinayake Gunawardhanalage Niranja Hemali Gunawardhana', 'Niranja', 'Niranja@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (4, 'Kachchakaduge Nilanka Sajeewani Peiris', 'Nilanka', 'Nilanka@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (5, 'K K Tilki Subhashini De Alwis', 'Tilki', 'Tilki@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (6, 'Hewawasan Jayasooriyage Ruwan Nishantha Jayasooriya', 'Ruwan', 'Ruwan@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (7, 'Nawagamuwage Kalhari Ganga Perera', 'Kalhari', 'Kalhari@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (8, 'M.A Hiruni Sulochana Madhuwanthi', 'Hiruni', 'Hiruni@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (9, 'C.M.R Tharuka Sathsarani', 'Tharuka', 'Tharuka@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (10, 'K.M Nirosha Madushika Karunarathne', 'Nirosha', 'Nirosha@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (11, 'Nethmi Shehani Kasthuriarachchi', 'Nethmi', 'Nethmi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (12, 'M R H Maheshi Meegalla', 'Maheshi', 'Maheshi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (13, 'Dissanayake Mudiyanselage Upeksha Chethana Dissanayake', 'Chethana', 'Chethana@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (14, 'M D Piyumika S Weerasinghe', 'Piyumika', 'Piyumika@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (15, 'Shavinke Nimesh Nicol Trimanne', 'Shavinke', 'Shavinke@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (16, 'Hasandi Nethmi Wickrmasooriya', 'Hasandi', 'Hasandi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (17, 'Assarapullige Roshel Anjala De Silva', 'Roshel', 'Roshel@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (18, 'Shakila Anushki Wanigasinghe', 'Shakila', 'Shakila@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (19, 'Bodiyabaduge Roshenka Madhushani Fernando', 'Roshenka', 'Roshenka@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (20, 'Niyagama Pathiranage Okitma Sandanaki', 'Okithma', 'Okithma@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (21, 'W A Wathsala Madhubhasini ', 'Wathsala', 'Wathsala@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (22, 'R A Nethmi Nayanathara', 'Nayanathara', 'Nayanathara@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (23, 'Wanni Arachchige Saranga Iresh Fonseka ', 'Saranga', 'Saranga@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (24, 'Athauda Arachchilage Chaminda Sisira Kumara Athauda Arachchi', 'Chamin', 'Chamin@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (25, 'V A Sameera Chathuranga', 'Sameera', 'Sameera@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (26, 'M A S Anuththara', 'Shenali', 'Shenali@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (27, 'Disavi Tharuni Harangala', 'Disavi', 'Disavi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (28, 'W S W Weerasooriya', 'Warshana', 'Warshana@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (29, 'G R Welgama', 'Geesha', 'Geesha@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (30, 'L M S Perera', 'Eshmi', 'Eshmi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (31, 'J I D Gunasekara', 'Isara', 'Isara@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (32, 'Fritz Roy Royen', 'Roy', 'Roy@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (33, 'B Proyadarshana Lal', 'Priyadarshana', 'Priyadarshana@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (34, 'W A Lalith Senani Bandula Jayakody', 'Jayakody', 'Jayakody@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (35, 'B L Ranidu Chamara', 'Chamara', 'Chamara@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (36, 'K J R Perera', 'Janith', 'Janith@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (37, 'Fritz Roy Royen', 'Roy', 'Roy@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (38, 'B Proyadarshana Lal', 'Priyadarshana', 'Priyadarshana@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (39, 'W A Lalith Senani Bandula Jayakody', 'Jayakody', 'Jayakody@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (40, 'B L Ranidu Chamara', 'Chamara', 'Chamara@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (41, 'K J R Perera', 'Janith', 'Janith@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (42, 'K D Sudath Wickramathilake', 'Sudath', 'Sudath@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (43, 'Allewela Pahalage Sriyalatha', 'Sriyalatha', 'Sriyalatha@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (44, 'B A Chithrangani', 'Chithrangani', 'Chithrangani@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (45, 'Nuwarapakshage Chandradasa', 'Chandradasa', 'Chandradasa@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (46, 'H P Sepalika', 'Sepalika', 'Sepalika@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (47, 'Madawanage Champika Kumari', 'Champika', 'Champika@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (48, 'R Sithumi Bhagya Senevirathne', 'Sithumi', 'Sithumi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);


-- ----------------------------
-- Primary Key structure for table user
-- ----------------------------
ALTER TABLE "public"."user" ADD CONSTRAINT "user_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_id_seq"
OWNED BY "public"."user"."id";
SELECT setval('"public"."user_id_seq"', 10, true);