-- ----------------------------
-- Table structure for chat_message_read_receipts
-- ----------------------------
DROP TABLE IF EXISTS "public"."chat_message_read_receipts";

CREATE TABLE "public"."chat_message_read_receipts" (
    "id" bigserial PRIMARY KEY,
    "chat_message_id" int8 NOT NULL,
    "user_id" int8 NOT NULL,
    "read_at" timestamp(0) DEFAULT now(),
    "created_at" timestamp(0) DEFAULT now(),
    "updated_at" timestamp(0) DEFAULT now()
);

-- ----------------------------
-- Foreign Key constraints
-- ----------------------------
ALTER TABLE "public"."chat_message_read_receipts" 
ADD CONSTRAINT "chat_message_read_receipts_message_id_fkey" 
FOREIGN KEY ("chat_message_id") REFERENCES "public"."chat_messages" ("id") ON DELETE CASCADE;

ALTER TABLE "public"."chat_message_read_receipts" 
ADD CONSTRAINT "chat_message_read_receipts_user_id_fkey" 
FOREIGN KEY ("user_id") REFERENCES "public"."user" ("id") ON DELETE CASCADE;

-- ----------------------------
-- Indexes for table chat_message_read_receipts
-- ----------------------------
CREATE INDEX "idx_chat_msg_receipts_message_id" ON "public"."chat_message_read_receipts" USING btree ("chat_message_id");
CREATE INDEX "idx_chat_msg_receipts_user_id" ON "public"."chat_message_read_receipts" USING btree ("user_id");
CREATE UNIQUE INDEX "idx_chat_msg_receipts_unique_user_msg" ON "public"."chat_message_read_receipts" ("chat_message_id", "user_id");
