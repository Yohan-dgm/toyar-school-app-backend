/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_backend_v1
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 06/10/2025 16:00:00
 */
-- ----------------------------
-- Sequence structure for edu_fb_predefined_question_ey_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_predefined_question_ey_id_seq";

CREATE SEQUENCE "public"."edu_fb_predefined_question_ey_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fb_predefined_question_ey
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb_predefined_question_ey";

CREATE TABLE "public"."edu_fb_predefined_question_ey" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fb_predefined_question_ey_id_seq' :: regclass),
    "question" text COLLATE "pg_catalog"."default",
    "edu_fb_category_ey_id" int8,
    "edu_fb_answer_type_id" int8,
    "is_active" boolean DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of edu_fb_predefined_question_ey (Early Years specific questions)
-- ----------------------------
-- Physical Development questions
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (1, 'How well does the child demonstrate gross motor skills (running, jumping, climbing)?', 1, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (2, 'How effectively does the child use fine motor skills (drawing, cutting, building)?', 1, 1, true, NULL, NULL, NULL, NULL);

-- Social and Emotional Development questions
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (3, 'How well does the child interact and play cooperatively with peers?', 2, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (4, 'How does the child manage emotions and transitions?', 2, 1, true, NULL, NULL, NULL, NULL);

-- Language and Communication questions
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (5, 'How clearly does the child express needs and ideas?', 3, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (6, 'How well does the child listen and follow simple instructions?', 3, 1, true, NULL, NULL, NULL, NULL);

-- Cognitive Development questions
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (7, 'How does the child approach problem-solving activities?', 4, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (8, 'How well does the child demonstrate memory and attention skills?', 4, 1, true, NULL, NULL, NULL, NULL);

-- Creative Expression questions
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (9, 'How creatively does the child engage in art and music activities?', 5, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (10, 'How does the child use imagination in play?', 5, 1, true, NULL, NULL, NULL, NULL);

-- Self-Care Skills questions
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (11, 'How independently does the child manage personal hygiene tasks?', 6, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (12, 'How well does the child take care of personal belongings?', 6, 1, true, NULL, NULL, NULL, NULL);

-- Play and Exploration questions
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (13, 'How actively does the child engage in exploratory play?', 7, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (14, 'How does the child demonstrate curiosity about the world?', 7, 1, true, NULL, NULL, NULL, NULL);

-- Early Literacy Skills questions
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (15, 'How does the child show interest in books and stories?', 8, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (16, 'How well does the child recognize letters and sounds?', 8, 1, true, NULL, NULL, NULL, NULL);

-- Early Numeracy Skills questions
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (17, 'How does the child demonstrate understanding of numbers and counting?', 9, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_ey" VALUES (18, 'How well does the child recognize shapes and patterns?', 9, 1, true, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table edu_fb_predefined_question_ey
-- ----------------------------
ALTER TABLE
    "public"."edu_fb_predefined_question_ey"
ADD
    CONSTRAINT "edu_fb_predefined_question_ey_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_predefined_question_ey_id_seq" OWNED BY "public"."edu_fb_predefined_question_ey"."id";

SELECT
    setval(
        '"public"."edu_fb_predefined_question_ey_id_seq"',
        18,
        true
    );