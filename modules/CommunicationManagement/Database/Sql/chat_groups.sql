-- ----------------------------
-- Sequence structure for chat_groups_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."chat_groups_id_seq";

CREATE SEQUENCE "public"."chat_groups_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for chat_groups
-- ----------------------------
DROP TABLE IF EXISTS "public"."chat_groups";

CREATE TABLE "public"."chat_groups" (
    "id" int8 NOT NULL DEFAULT nextval('chat_groups_id_seq'::regclass),
    "name" varchar(100) COLLATE "pg_catalog"."default",
    "type" varchar(20) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'direct',
    "avatar_url" varchar(500) COLLATE "pg_catalog"."default",
    "school_id" int8,
    "is_disabled" bool DEFAULT false,
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "deleted_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table chat_groups
-- ----------------------------
ALTER TABLE "public"."chat_groups" 
ADD CONSTRAINT "chat_groups_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Check constraints
-- ----------------------------
ALTER TABLE "public"."chat_groups" 
ADD CONSTRAINT "chat_groups_type_check" 
CHECK (type IN ('direct', 'group'));

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."chat_groups_id_seq" 
OWNED BY "public"."chat_groups"."id";

-- ----------------------------
-- Indexes for table chat_groups
-- ----------------------------
CREATE INDEX "idx_chat_groups_type" ON "public"."chat_groups" USING btree ("type");
CREATE INDEX "idx_chat_groups_school_id" ON "public"."chat_groups" USING btree ("school_id");
CREATE INDEX "idx_chat_groups_created_by" ON "public"."chat_groups" USING btree ("created_by");
CREATE INDEX "idx_chat_groups_active" ON "public"."chat_groups" USING btree ("is_active");
CREATE INDEX "idx_chat_groups_deleted_at" ON "public"."chat_groups" USING btree ("deleted_at") WHERE deleted_at IS NOT NULL;
