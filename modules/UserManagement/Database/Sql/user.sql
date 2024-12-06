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
INSERT INTO "public"."user" VALUES (0, 'Wasala Tanthrige Noyeli Hansika Perera', 'Noyeli', 'Noyeli@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Sirinayake Gunawardhanalage Niranja Hemali Gunawardhana', 'Niranja', 'Niranja@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Kachchakaduge Nilanka Sajeewani Peiris', 'Nilanka', 'Nilanka@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'K K Tilki Subhashini De Alwis', 'Tilki', 'Tilki@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Hewawasan Jayasooriyage Ruwan Nishantha Jayasooriya', 'Ruwan', 'Ruwan@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Nawagamuwage Kalhari Ganga Perera', 'Kalhari', 'Kalhari@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'M.A Hiruni Sulochana Madhuwanthi', 'Hiruni', 'Hiruni@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'C.M.R Tharuka Sathsarani', 'Tharuka', 'Tharuka@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'K.M Nirosha Madushika Karunarathne', 'Nirosha', 'Nirosha@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Nethmi Shehani Kasthuriarachchi', 'Nethmi', 'Nethmi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'M R H Maheshi Meegalla', 'Maheshi', 'Maheshi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Dissanayake Mudiyanselage Upeksha Chethana Dissanayake', 'Chethana', 'Chethana@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'R Sithumi Bhagya Senevirathne', 'Sithumi', 'Sithumi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'M D Piyumika S Weerasinghe', 'Piyumika', 'Piyumika@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Shavinke Nimesh Nicol Trimanne', 'Shavinke', 'Shavinke@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Hasandi Nethmi Wickrmasooriya', 'Hasandi', 'Hasandi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Assarapullige Roshel Anjala De Silva', 'Roshel', 'Roshel@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Shakila Anushki Wanigasinghe', 'Shakila', 'Shakila@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Bodiyabaduge Roshenka Madhushani Fernando', 'Roshenka', 'Roshenka@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Niyagama Pathiranage Okitma Sandanaki', 'Okithma', 'Okithma@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'W A Wathsala Madhubhasini ', 'Wathsala', 'Wathsala@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'R A Nethmi Nayanathara', 'Nayanathara', 'Nayanathara@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Wanni Arachchige Saranga Iresh Fonseka ', 'Saranga', 'Saranga@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Athauda Arachchilage Chaminda Sisira Kumara Athauda Arachchi', 'Chamin', 'Chamin@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'V A Sameera Chathuranga', 'Sameera', 'Sameera@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'M A S Anuththara', 'Shenali', 'Shenali@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Disavi Tharuni Harangala', 'Disavi', 'Disavi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'W S W Weerasooriya', 'Warshana', 'Warshana@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'G R Welgama', 'Geesha', 'Geesha@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'L M S Perera', 'Eshmi', 'Eshmi@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'J I D Gunasekara', 'Isara', 'Isara@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Fritz Roy Royen', 'Roy', 'Roy@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'B Proyadarshana Lal', 'Priyadarshana', 'Priyadarshana@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'W A Lalith Senani Bandula Jayakody', 'Jayakody', 'Jayakody@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'B L Ranidu Chamara', 'Chamara', 'Chamara@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'K J R Perera', 'Janith', 'Janith@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Fritz Roy Royen', 'Roy', 'Roy@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'B Proyadarshana Lal', 'Priyadarshana', 'Priyadarshana@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'W A Lalith Senani Bandula Jayakody', 'Jayakody', 'Jayakody@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'B L Ranidu Chamara', 'Chamara', 'Chamara@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'K J R Perera', 'Janith', 'Janith@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'K D Sudath Wickramathilake', 'Sudath', 'Sudath@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Allewela Pahalage Sriyalatha', 'Sriyalatha', 'Sriyalatha@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'B A Chithrangani', 'Chithrangani', 'Chithrangani@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Nuwarapakshage Chandradasa', 'Chandradasa', 'Chandradasa@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'H P Sepalika', 'Sepalika', 'Sepalika@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."user" VALUES (0, 'Madawanage Champika Kumari', 'Champika', 'Champika@nexiscollege.lk', NULL, ' $2y$12$WptK8Ri89rvFppc8OHqLVOUPX65DsDLZaMGHLNrfyQfG8gh8U9c3G', NULL, NULL, NULL, NULL, NULL);
