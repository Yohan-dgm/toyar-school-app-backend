/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 06/12/2024 15:57:05
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
INSERT INTO "public"."user" VALUES (9, 'M R H Maheshi Meegalla', 'maheshi', 'maheshi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (10, 'Dissanayake Mudiyanselage Upeksha Chethana Dissanayake', 'chethana', 'chethana@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (12, 'M D Piyumika S Weerasinghe', 'piyumika', 'piyumika@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (2, 'Wasala Tanthrige Noyeli Hansika Perera', 'noyeli', 'noyeli@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (3, 'Sirinayake Gunawardhanalage Niranja Hemali Gunawardhana', 'niranja', 'niranja@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (4, 'Kachchakaduge Nilanka Sajeewani Peiris', 'nilanka', 'nilanka@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (5, 'K K Tilki Subhashini De Alwis', 'tilki', 'tilki@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (17, 'Niyagama Pathiranage Okitma Sandanaki', 'okithma', 'okithma@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (1, 'Sevwandi Lanka Kankanamge', 'sevwandi', 'sevwandi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (6, 'C M R Tharuka Sathsarani', 'tharuka', 'tharuka@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (7, 'K M Nirosha Madushika Karunarathne', 'nirosha', 'nirosha@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (8, 'Nethmi Shehani Kasthuriarachchi', 'nethmi', 'nethmi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (16, 'Bodiyabaduge Roshenka Madhushani Fernando', 'roshenka', 'roshenka@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (15, 'Shakila Anushki Wanigasinghe', 'shakila', 'shakila@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (14, 'Assarapullige Roshel Anjala De Silva', 'roshel', 'roshel@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (13, 'Shavinke Nimesh Nicol Trimanne', 'shavinke', 'shavinke@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (18, 'W A Wathsala Madhubhasini ', 'wathsala', 'wathsala@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (19, 'R A Nethmi Nayanathara', 'nayanathara', 'nayanathara@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (20, 'Wanni Arachchige Saranga Iresh Fonseka ', 'saranga', 'saranga@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (21, 'Athauda Arachchilage Chaminda Sisira Kumara Athauda Arachchi', 'chamin', 'chamin@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (22, 'V A Sameera Chathuranga', 'sameera', 'sameera@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (23, 'M A S Anuththara', 'shenali', 'shenali@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (24, 'Disavi Tharuni Harangala', 'disavi', 'disavi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (25, 'W S W Weerasooriya', 'warshana', 'warshana@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (26, 'G R Welgama', 'geesha', 'geesha@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (27, 'L M S Perera', 'eshmi', 'eshmi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (28, 'J I D Gunasekara', 'isara', 'isara@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (29, 'Fritz Roy Royen', 'roy', 'roy@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (30, 'B Proyadarshana Lal', 'priyadarshana', 'priyadarshana@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (31, 'W A Lalith Senani Bandula Jayakody', 'jayakody', 'jayakody@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (32, 'B L Ranidu Chamara', 'chamara', 'chamara@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (33, 'K J R Perera', 'janith', 'janith@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (11, 'R Sithumi Bhagya Senevirathne', 'sithumi', 'sithumi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table user
-- ----------------------------
ALTER TABLE "public"."user" ADD CONSTRAINT "user_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_id_seq"
OWNED BY "public"."user"."id";
SELECT setval('"public"."user_id_seq"', 33, true);
