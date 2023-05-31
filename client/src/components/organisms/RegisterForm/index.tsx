import { SubmitHandler, useForm } from "react-hook-form";
import { InputTextGroup } from "@/components/molecures/InputTextGroup";
import { DarkOrangeButton } from "@/components/atoms/Button/DarkOrangeButton";
import { PostRequest } from "@/api/api/register";
import styles from "./index.module.scss";
import { InputTextAreaGroup } from "@/components/molecures/InputTextAreaGroup";
import { InputImage } from "@/components/molecures/InputImage";
import { useState } from "react";
import { UserIcon } from "@/components/atoms/UserIcon";
import { apiRegisterUser } from "@/modules/api/register";
import axios from "axios";
import { useAuth } from "@/hooks/user/useAuth";
import { useRouter } from "next/router";
import { ROUTE_PATHNAME } from "@/constants/route";
import { Alert } from "@/components/molecures/Alert";
import { ErrorResponse, errorDictToString } from "@/types/response";
import { ERROR_MESSAGE } from "@/constants/api";
import { useSafePush } from "@/hooks/route/useSafePush";

export const RegisterForm = () => {
  const {
    register,
    handleSubmit,
    setValue,
    formState: { errors, isValid },
  } = useForm<PostRequest>();
  const [previewIcon, setPreviewIcon] = useState<string>("");
  const [_, setUser] = useAuth();
  const [error, setError] = useState("");
  const safePush = useSafePush();

  const handleRegister: SubmitHandler<PostRequest> = async (request) => {
    try {
      const res = await apiRegisterUser(request);
      setUser(res.data);
      safePush(ROUTE_PATHNAME.TOP);
    } catch (e) {
      if (axios.isAxiosError(e)) {
        const status = e.response?.status;
        const res = e.response?.data as ErrorResponse;

        if (status === 400) {
          setError(errorDictToString(res.data));
          return;
        }
        setError(res.message);
        return;
      }
      setError(ERROR_MESSAGE.UNKNOWN_ERROR);
    }
  };

  const changeInputFile = (e: React.ChangeEvent<HTMLInputElement>) => {
    const files = e.target.files!;

    if (files[0]) {
      setValue("icon", files[0]);
      setPreviewIcon(URL.createObjectURL(files[0]));
    }
  };

  return (
    <div className={styles.formWrapper}>
      <Alert designType="error">{error}</Alert>
      <form onSubmit={handleSubmit(handleRegister)} className={styles.form}>
        <div className={styles.formUploadIcon}>
          <UserIcon width={240} height={240} icon={previewIcon} />
          <InputImage
            onChange={changeInputFile}
            register={register}
            displayName="アイコンをアップロード"
            validation={{
              required: "アイコンをアップロードしてください。",
            }}
            name="icon"
            error={errors?.icon?.message}
          />
        </div>

        <div className={styles.formInputTexts}>
          <InputTextGroup
            designType="gray"
            register={register}
            type="text"
            validation={{
              required: "ユーザー名を入力してください。",
              maxLength: {
                value: 255,
                message: "有効なユーザー名を入力してください。",
              },
            }}
            name="username"
            displayName="ユーザー名"
            placeholder="example"
            require={true}
            error={errors?.username?.message}
          />
          <InputTextGroup
            designType="gray"
            register={register}
            type="password"
            displayName="パスワード"
            validation={{
              required: "パスワードを入力してください。",
              maxLength: {
                value: 255,
                message: "有効なパスワードを入力してください。",
              },
            }}
            name="password"
            placeholder=""
            require={true}
            error={errors?.password?.message}
          />
          <InputTextGroup
            designType="gray"
            register={register}
            type="name"
            displayName="名前"
            validation={{
              required: "名前を入力してください。",
              maxLength: {
                value: 255,
                message: "有効な名前を入力してください。",
              },
            }}
            name="name"
            placeholder=""
            require={true}
            error={errors?.name?.message}
          />
          <InputTextAreaGroup
            designType="gray"
            register={register}
            displayName="性格"
            validation={{
              required: "性格を入力してください。",
              maxLength: {
                value: 512,
                message: "有効な性格を入力してください。",
              },
            }}
            name="personality"
            placeholder="厳しい言葉をかけられたらやる気になります。"
            require={true}
            error={errors?.personality?.message}
          />
          <DarkOrangeButton disabled={!isValid}>登録</DarkOrangeButton>
        </div>
      </form>
    </div>
  );
};
