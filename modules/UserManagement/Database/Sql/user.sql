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
 
 Date: 17/12/2024 12:25:49
 */
-- ----------------------------
-- Sequence structure for user_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."user_id_seq";

CREATE SEQUENCE "public"."user_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS "public"."user";

CREATE TABLE "public"."user" (
    "id" int8 NOT NULL DEFAULT nextval('user_id_seq' :: regclass),
    "full_name" varchar(255) COLLATE "pg_catalog"."default",
    "username" varchar(255) COLLATE "pg_catalog"."default",
    "email" varchar(255) COLLATE "pg_catalog"."default",
    "email_verified_at" timestamp(0),
    "password" varchar(255) COLLATE "pg_catalog"."default",
    "remember_token" varchar(100) COLLATE "pg_catalog"."default",
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "created_by" int8,
    "update_by" int8,
    "password_new" varchar(255) COLLATE "pg_catalog"."default",
    "is_system_update_pending" bool DEFAULT false,
    "is_active" bool DEFAULT false,
);

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO
    "public"."user"
VALUES
    (
        32,
        'B L Ranidu Chamara',
        'chamara',
        'chamara@nexiscollege.lk',
        NULL,
        '$2y$12$1S9J7gjdRUibFrW76k5djuqtyD8QPEKFu.rPwwrnKcGyqUCGv2yuq',
        NULL,
        NULL,
        '2024-12-17 12:31:41',
        NULL,
        NULL,
        'chamara2327'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        6,
        'C M R Tharuka Sathsarani',
        'tharuka',
        'tharuka@nexiscollege.lk',
        NULL,
        '$2y$12$6QvQ/IIMQlQXmh4r0Bs36u1Gl9ivN3f76.K6WY78eYg1KhRjkUGYG',
        NULL,
        NULL,
        '2024-12-17 12:31:43',
        NULL,
        NULL,
        'tharuka4660'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        7,
        'K M Nirosha Madushika Karunarathne',
        'nirosha',
        'nirosha@nexiscollege.lk',
        NULL,
        '$2y$12$S/0IF7.Ildh1uE/Xht2wbuHYwFXxQo73NN.q4m8.EddhWgFg.xIB.',
        NULL,
        NULL,
        '2024-12-17 12:31:43',
        NULL,
        NULL,
        'nirosha5870'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        9,
        'M R H Maheshi Meegalla',
        'maheshi',
        'maheshi@nexiscollege.lk',
        NULL,
        '$2y$12$v2lvcZSfPnnYhRg.QsS9NeIY6So.GACgwHgfFgcwXltjITSOSPF8K',
        NULL,
        NULL,
        '2024-12-17 12:31:44',
        NULL,
        NULL,
        'maheshi6550'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        10,
        'Dissanayake Mudiyanselage Upeksha Chethana Dissanayake',
        'chethana',
        'chethana@nexiscollege.lk',
        NULL,
        '$2y$12$2lDa3OBxbHFJnFlzhLCD6uH6mUKdVnUCzQUEnf9m1xa9rl9axe3iC',
        NULL,
        NULL,
        '2024-12-17 12:31:44',
        NULL,
        NULL,
        'chethana3426'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        14,
        'Assarapullige Roshel Anjala De Silva',
        'roshel',
        'roshel@nexiscollege.lk',
        NULL,
        '$2y$12$cKq7Cu.Qrg6yw3tIIxTvb.kIXFUwFX/fBU1RHTfK6iOeEW2Ur3zpu',
        NULL,
        NULL,
        '2024-12-17 12:31:44',
        NULL,
        NULL,
        'roshel7901'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        1,
        'Sevwandi Lanka Kankanamge',
        'sevwandi',
        'sevwandi@nexiscollege.lk',
        NULL,
        '$2y$12$eNMrFfR0RBtSk7heeBkPP.DUj4oJSkkNMMDuG0khUqbzh1EMnbWKy',
        NULL,
        NULL,
        '2024-12-17 12:31:44',
        NULL,
        NULL,
        'sevwandi7367'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        35,
        'Nawagamuwage Kalhari Ganga Perera',
        'kalhari',
        'kalhari@nexiscollege.lk',
        NULL,
        '$2y$12$jYki4Ckc8WVAZL3Ak1PjOO5dBdkNNtd7n8CP/mzCfp7F/SWIc5qvq',
        NULL,
        NULL,
        '2024-12-17 12:31:45',
        NULL,
        NULL,
        'kalhari5306'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        19,
        'R A Nethmi Nayanathara',
        'nayanathara',
        'nayanathara@nexiscollege.lk',
        NULL,
        '$2y$12$6HopTK6HeNGrL1bxKK/oj.IM3VpTKs20J.93Z2lmtpK/jq78uTMSS',
        NULL,
        NULL,
        '2024-12-17 12:31:45',
        NULL,
        NULL,
        'nayanathara1675'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        34,
        'Hewawasan Jayasooriyage Ruwan Nishantha Jayasooriya',
        'ruwan',
        'ruwan@nexiscollege.lk',
        NULL,
        '$2y$12$K5cD1NhicCv2igQ0Y0ZFruTLTDDL1K3ys8Q8FQ59hiXTLdihYVS72',
        NULL,
        NULL,
        '2024-12-17 12:31:45',
        NULL,
        NULL,
        'ruwan5780'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        37,
        'Hasandi Nethmi Wickrmasooriya',
        'hasandi',
        'hasandi@nexiscollege.lk',
        NULL,
        '$2y$12$gEBt9zhGMJqsYMEZb14inegbbFhW78Sm6gPRWIIwslBdl8.mtpzJm',
        NULL,
        NULL,
        '2024-12-17 12:31:46',
        NULL,
        NULL,
        'hasandi2440'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        27,
        'L M S Perera',
        'eshmi',
        'eshmi@nexiscollege.lk',
        NULL,
        '$2y$12$JNLRFmWjfbLfrADoRV2Vs.NbN.wUWemRKHlHRBloEPgkqVNicqy4.',
        NULL,
        NULL,
        '2024-12-17 12:31:46',
        NULL,
        NULL,
        'eshmi3941'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        3,
        'Sirinayake Gunawardhanalage Niranja Hemali Gunawardhana',
        'niranja',
        'niranja@nexiscollege.lk',
        NULL,
        '$2y$12$vd3r/FYp85jnpVx5pJ.juuUGSYSQcfzObzIk3vEUcUdWEuvBvXVPe',
        NULL,
        NULL,
        '2024-12-17 12:31:46',
        NULL,
        NULL,
        'niranja2344'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        4,
        'Kachchakaduge Nilanka Sajeewani Peiris',
        'nilanka',
        'nilanka@nexiscollege.lk',
        NULL,
        '$2y$12$XIk7r78svNjgbIyNnByTf./loGWA0DWy417JZJXGtaEe6roo.mWAO',
        NULL,
        NULL,
        '2024-12-17 12:31:46',
        NULL,
        NULL,
        'nilanka7704'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        15,
        'Shakila Anushki Wanigasinghe',
        'shakila',
        'shakila@nexiscollege.lk',
        NULL,
        '$2y$12$wViKX8I07YVe8kzmuZ1r1ODweeY6DWzKGHVHPZAiFSkkKOh7v8nZC',
        NULL,
        NULL,
        '2024-12-17 12:31:47',
        NULL,
        NULL,
        'shakila4120'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        16,
        'Bodiyabaduge Roshenka Madhushani Fernando',
        'roshenka',
        'roshenka@nexiscollege.lk',
        NULL,
        '$2y$12$.mmgkW1PCdglkPvsAHC1JuWdDr1S1STqn4Qhc.5ZNx2ErODlaRa9i',
        NULL,
        NULL,
        '2024-12-17 12:31:47',
        NULL,
        NULL,
        'roshenka3850'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        11,
        'R Sithumi Bhagya Senevirathne',
        'sithumi',
        'sithumi@nexiscollege.lk',
        NULL,
        '$2y$12$K6bdkYdbzp/YNl.oWThlpeIRinCVzMy1cJDVRHLPkjPJ.uqtf4EFu',
        NULL,
        NULL,
        '2024-12-17 12:31:47',
        NULL,
        NULL,
        'sithumi6877'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        25,
        'W S W Weerasooriya',
        'warshana',
        'warshana@nexiscollege.lk',
        NULL,
        '$2y$12$0YButapr3DKdLIHMESoz.eDV4bl0YIV/K.gSYFMo1kPepNP.T/8.O',
        NULL,
        NULL,
        '2024-12-17 12:31:47',
        NULL,
        NULL,
        'warshana9890'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        20,
        'Wanni Arachchige Saranga Iresh Fonseka ',
        'saranga',
        'saranga@nexiscollege.lk',
        NULL,
        '$2y$12$HPOuYrKN1VRBt90yaGvGUecgUVH9GPJ53myHQquF631e7QQDhSNzi',
        NULL,
        NULL,
        '2024-12-17 12:31:48',
        NULL,
        NULL,
        'saranga6752'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        30,
        'B Proyadarshana Lal',
        'priyadarshana',
        'priyadarshana@nexiscollege.lk',
        NULL,
        '$2y$12$0kHLmUEqPvloUa2DxUgVuuFzs7e8ZgGGysuQuj84dST3anrXqZ6Be',
        NULL,
        NULL,
        '2024-12-17 12:31:48',
        NULL,
        NULL,
        'priyadarshana4103'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        17,
        'Niyagama Pathiranage Okitma Sandanaki',
        'okithma',
        'okithma@nexiscollege.lk',
        NULL,
        '$2y$12$Y/IZeOJa2hqGhjEXpKf/6eAOD2ivdFTaB5g6TJT2U2Buytdpm.83S',
        NULL,
        NULL,
        '2024-12-17 12:31:48',
        NULL,
        NULL,
        'okithma6395'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        26,
        'G R Welgama',
        'geesha',
        'geesha@nexiscollege.lk',
        NULL,
        '$2y$12$/ebD77C0IZeuLMSZs5myn.zTAUlAlNRR95BaO5Y00sst8PXq/nbZ6',
        NULL,
        NULL,
        '2024-12-17 12:31:49',
        NULL,
        NULL,
        'geesha6616'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        29,
        'Fritz Roy Royen',
        'roy',
        'roy@nexiscollege.lk',
        NULL,
        '$2y$12$Jdxca5GfhJIedcmbZ0vgWeWGaw60wI3OuwWIeAT3RJcdFVM9nOr6G',
        NULL,
        NULL,
        '2024-12-17 12:31:49',
        NULL,
        NULL,
        'roy3293'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        28,
        'J I D Gunasekara',
        'isara',
        'isara@nexiscollege.lk',
        NULL,
        '$2y$12$YU4Fm48vtf462fLVWbBSseeRYcUITCwQDtbY2Xry3i0o0wnMSrI6O',
        NULL,
        NULL,
        '2024-12-17 12:31:49',
        NULL,
        NULL,
        'isara1781'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        33,
        'K J R Perera',
        'janith',
        'janith@nexiscollege.lk',
        NULL,
        '$2y$12$dh6Gm2gQGLbvKecg1rbdFOHlXYXiRfGoig1llG4aBbEx50JftH7Fq',
        NULL,
        NULL,
        '2024-12-17 12:31:49',
        NULL,
        NULL,
        'janith7762'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        38,
        'Mr. Lakshitha Wijerathne',
        'lakshitha',
        'lakshitha@nexiscollege.lk',
        NULL,
        '$2y$12$oQOf3A6UmydmQZnb4K2dkuXrj9Ds1KHkcSP2SEk50QFMS3SFtXRo2',
        NULL,
        NULL,
        '2024-12-17 12:31:50',
        NULL,
        NULL,
        'lakshitha5759'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        39,
        'Mrs. Nadeesha Wijerathne',
        'nadeesha',
        'nadeesha@nexiscollege.lk',
        NULL,
        '$2y$12$YOpggtDXoyAvsY0ZDO0HDeyVt.wTVXY0NUNL1h361KRbO6dnH3JhW',
        NULL,
        NULL,
        '2024-12-17 12:31:50',
        NULL,
        NULL,
        'nadeesha6346'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        5,
        'K K Tilki Subhashini De Alwis',
        'tilki',
        'tilki@nexiscollege.lk',
        NULL,
        '$2y$12$XuAg7F61pBomK/z6p5V29eGpmUlhcE80ORDdAyOUz1t6x2/TaHCdi',
        NULL,
        NULL,
        '2024-12-17 12:31:50',
        NULL,
        NULL,
        'tilki5185'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        23,
        'M A S Anuththara',
        'shenali',
        'shenali@nexiscollege.lk',
        NULL,
        '$2y$12$kBDAVKAMo26DCgD18ZJ.sOAC6H41yI5f/7ShWaCoeBCol6nDZuef.',
        NULL,
        NULL,
        '2024-12-17 12:31:50',
        NULL,
        NULL,
        'shenali8168'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        8,
        'Nethmi Shehani Kasthuriarachchi',
        'nethmi',
        'nethmi@nexiscollege.lk',
        NULL,
        '$2y$12$GoLpPUyihadBV4P6RtObquBrO7Bxd6ly6zIXKmc.SPhzf0wEFwwL6',
        NULL,
        NULL,
        '2024-12-17 12:31:51',
        NULL,
        NULL,
        'nethmi4527'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        18,
        'W A Wathsala Madhubhasini ',
        'wathsala',
        'wathsala@nexiscollege.lk',
        NULL,
        '$2y$12$AomoSdtShtpVuLx9.9MMIO8uDj58yP86XQzx7fMlGaMZX.YDFOYHu',
        NULL,
        NULL,
        '2024-12-17 12:31:51',
        NULL,
        NULL,
        'wathsala6442'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        31,
        'W A Lalith Senani Bandula Jayakody',
        'jayakody',
        'jayakody@nexiscollege.lk',
        NULL,
        '$2y$12$P7MGlkgf7k0agtwZO6RP1.A33Q/BBCfQHgiJdVM2V8kTYJjCHBlOC',
        NULL,
        NULL,
        '2024-12-17 12:31:41',
        NULL,
        NULL,
        'jayakody9306'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        36,
        'M.A Hiruni Sulochana',
        'hiruni',
        'hiruni@nexiscollege.lk',
        NULL,
        '$2y$12$uEhmrTwYZe0CX3YGRqHieObOt6kGS.lkQddx0byHfQWyOP7ezXBoq',
        NULL,
        NULL,
        '2024-12-17 12:31:41',
        NULL,
        NULL,
        'hiruni5239'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        12,
        'M D Piyumika S Weerasinghe',
        'piyumika',
        'piyumika@nexiscollege.lk',
        NULL,
        '$2y$12$IeKYz.FPZDK5l7.9NxNexuvXU9HIXlOEL98ZhZx2KrHE11q23S1ua',
        NULL,
        NULL,
        '2024-12-17 12:31:41',
        NULL,
        NULL,
        'piyumika4231'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        24,
        'Disavi Tharuni Harangala',
        'disavi',
        'disavi@nexiscollege.lk',
        NULL,
        '$2y$12$Nqg6K9KZuwpgXXYXvm7gs.y4O4RRtFoUEFGUiWQlQa/0zRSL8VG9e',
        NULL,
        NULL,
        '2024-12-17 12:31:42',
        NULL,
        NULL,
        'disavi2010'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        2,
        'Wasala Tanthrige Noyeli Hansika Perera',
        'noyeli',
        'noyeli@nexiscollege.lk',
        NULL,
        '$2y$12$cku.vp9Sru4gLpn/NCY26.IL0RveBl64ecOA1q2p3M8wW.KMnDwju',
        NULL,
        NULL,
        '2024-12-17 12:31:42',
        NULL,
        NULL,
        'noyeli7726'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        13,
        'Shavinke Nimesh Nicol Trimanne',
        'shavinke',
        'shavinke@nexiscollege.lk',
        NULL,
        '$2y$12$ag/d5SyUsrne5kc9m6xCm.OneSYdQA658jBsC3KtPr/JcRiCT5F7O',
        NULL,
        NULL,
        '2024-12-17 12:31:42',
        NULL,
        NULL,
        'shavinke8650'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        21,
        'Athauda Arachchilage Chaminda Sisira Kumara Athauda Arachchi',
        'chamin',
        'chamin@nexiscollege.lk',
        NULL,
        '$2y$12$pBvvH9wAktMir3Jy2Q69le0YaQajw0NeHEf80tkgWEiWIrif3UdSC',
        NULL,
        NULL,
        '2024-12-17 12:31:43',
        NULL,
        NULL,
        'chamin6012'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        22,
        'V A Sameera Chathuranga',
        'sameera',
        'sameera@nexiscollege.lk',
        NULL,
        '$2y$12$sD2tqsk/Y.4UsV5U1ZKy/.f4Og138UK3iJMUCKnMAqLy4Jd97/zS.',
        NULL,
        NULL,
        '2024-12-17 12:31:43',
        NULL,
        NULL,
        'sameera4118'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        40,
        'Saman Bollegala',
        'saman',
        'saman@nexiscollege.lk',
        NULL,
        '$2y$12$rXNGT4q3jLZ7GOvfIHEpXePMj9yWCDhgDt9OECo.K2HRL6aioYrT2',
        NULL,
        NULL,
        '2024-12-26 09:16:34',
        NULL,
        NULL,
        'saman2963'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        41,
        'Mithun Fernando',
        'mithun',
        'mithun@nexiscollege.lk',
        NULL,
        '$2y$12$GCWTnR0swnEaVW7h3xx.keyVNR6jwjlEm9erW2AkHsBKGBkSvPPX.',
        NULL,
        NULL,
        '2024-12-26 09:16:50',
        NULL,
        NULL,
        'mithun2832'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        42,
        'Thanujitha',
        'thanujitha',
        'thanujitha@nexiscollege.lk',
        NULL,
        '$2y$12$WWyCR1aFbmAlTt3.xPJkde4pYKLQ./gcGwwj347N7ttSPETg/.JNC',
        NULL,
        NULL,
        '2024-12-26 09:16:57',
        NULL,
        NULL,
        'thanujitha5645'
    );

INSERT INTO
    "public"."user"
VALUES
    (
        43,
        'Yohan ',
        'yohan',
        'yohan@nexiscollege.lk',
        NULL,
        '$2y$12$qMGjAuB6e5tFMwHHoJElfuqEeQv9RplydOjdnzkl.8VwY50xv9YDe',
        NULL,
        NULL,
        '2024-12-26 09:17:03',
        NULL,
        NULL,
        'yohan4058'
    );

-- ----------------------------
-- Primary Key structure for table user
-- ----------------------------
ALTER TABLE
    "public"."user"
ADD
    CONSTRAINT "user_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_id_seq" OWNED BY "public"."user"."id";

SELECT
    setval('"public"."user_id_seq"', 43, true);