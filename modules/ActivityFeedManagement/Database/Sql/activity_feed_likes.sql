-- ----------------------------
-- Sequence structure for activity_feed_likes_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."activity_feed_likes_id_seq";

CREATE SEQUENCE "public"."activity_feed_likes_id_seq"
    INCREMENT 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    START 1
    CACHE 1;

-- ----------------------------
-- Table structure for activity_feed_likes
-- ----------------------------
DROP TABLE IF EXISTS "public"."activity_feed_likes";

CREATE TABLE "public"."activity_feed_likes" (
    "id" int8 NOT NULL DEFAULT nextval('activity_feed_likes_id_seq' :: regclass),
    "post_id" int8 NOT NULL,
    "user_id" int8 NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of activity_feed_likes
-- ----------------------------
INSERT INTO "public"."activity_feed_likes" VALUES
(1, 1, 1, '2024-01-15 09:30:00', '2024-01-15 09:30:00'),
(2, 1, 2, '2024-01-15 10:15:00', '2024-01-15 10:15:00'),
(3, 1, 3, '2024-01-15 11:00:00', '2024-01-15 11:00:00'),
(4, 2, 1, '2024-01-20 11:00:00', '2024-01-20 11:00:00'),
(5, 2, 2, '2024-01-20 11:30:00', '2024-01-20 11:30:00'),
(6, 2, 4, '2024-01-20 12:00:00', '2024-01-20 12:00:00'),
(7, 3, 1, '2024-01-25 15:00:00', '2024-01-25 15:00:00'),
(8, 3, 3, '2024-01-25 15:30:00', '2024-01-25 15:30:00'),
(9, 4, 1, '2024-02-01 12:00:00', '2024-02-01 12:00:00'),
(10, 4, 2, '2024-02-01 12:30:00', '2024-02-01 12:30:00'),
(11, 4, 3, '2024-02-01 13:00:00', '2024-02-01 13:00:00'),
(12, 4, 4, '2024-02-01 13:30:00', '2024-02-01 13:30:00'),
(13, 5, 1, '2024-02-05 09:00:00', '2024-02-05 09:00:00'),
(14, 5, 2, '2024-02-05 09:30:00', '2024-02-05 09:30:00');

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."activity_feed_likes_id_seq" OWNED BY "public"."activity_feed_likes"."id";

-- ----------------------------
-- Primary Key structure for table activity_feed_likes
-- ----------------------------
ALTER TABLE "public"."activity_feed_likes" ADD CONSTRAINT "activity_feed_likes_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Unique constraint for table activity_feed_likes
-- ----------------------------
ALTER TABLE "public"."activity_feed_likes" ADD CONSTRAINT "unique_post_user_like" UNIQUE ("post_id", "user_id");

-- ----------------------------
-- Indexes for table activity_feed_likes
-- ----------------------------
CREATE INDEX "idx_activity_feed_likes_post_id" ON "public"."activity_feed_likes" USING btree ("post_id");
CREATE INDEX "idx_activity_feed_likes_user_id" ON "public"."activity_feed_likes" USING btree ("user_id");

-- ----------------------------
-- Foreign Keys structure for table activity_feed_likes
-- ----------------------------
ALTER TABLE "public"."activity_feed_likes" ADD CONSTRAINT "fk_activity_feed_likes_post_id" FOREIGN KEY ("post_id") REFERENCES "public"."activity_feed_posts" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;
