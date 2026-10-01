/*
 Student Post Likes Table - Dedicated likes table for student posts
 
 Date: 11/09/2025
*/

-- ----------------------------
-- Sequence structure for student_post_likes_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_post_likes_id_seq";

CREATE SEQUENCE "public"."student_post_likes_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for student_post_likes
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_post_likes";

CREATE TABLE "public"."student_post_likes" (
    "id" int8 NOT NULL DEFAULT nextval('student_post_likes_id_seq'::regclass),
    "post_id" int8 NOT NULL,
    "user_id" int8 NOT NULL,
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table student_post_likes
-- ----------------------------
ALTER TABLE "public"."student_post_likes" 
ADD CONSTRAINT "student_post_likes_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Unique constraint for table student_post_likes
-- ----------------------------
ALTER TABLE "public"."student_post_likes" 
ADD CONSTRAINT "unique_student_post_user_like" UNIQUE ("post_id", "user_id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_post_likes_id_seq" 
OWNED BY "public"."student_post_likes"."id";

SELECT setval('"public"."student_post_likes_id_seq"', 1, false);

-- ----------------------------
-- Indexes for table student_post_likes
-- ----------------------------
CREATE INDEX "idx_student_post_likes_post_id" ON "public"."student_post_likes" USING btree ("post_id");
CREATE INDEX "idx_student_post_likes_user_id" ON "public"."student_post_likes" USING btree ("user_id");
CREATE INDEX "idx_student_post_likes_created_at" ON "public"."student_post_likes" USING btree ("created_at" DESC);