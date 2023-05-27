import { SubmitHandler, useForm } from "react-hook-form";
import { InputTextGroup } from "@/components/molecures/InputTextGroup";
import { DarkOrangeButton } from "@/components/atoms/Button/DarkOrangeButton";
import { PostRequest, apiLogin } from "@/modules/api/login";
import styles from "./index.module.scss";
import { useAuth } from "@/hooks/user/useAuth";
import axios from "axios";
import { Alert } from "@/components/molecures/Alert";
import { useState } from "react";
import { ErrorResponse, errorDictToString } from "@/types/response";
import { useRouter } from "next/router";
import { ROUTE_PATHNAME } from "@/constants/route";
import { ERROR_MESSAGE } from "@/constants/api";

export const LoginForm = () => {
  const {
    register,
    handleSubmit,
    formState: { errors, isValid },
  } = useForm<PostRequest>();
  const [_, setUser] = useAuth();
  const router = useRouter();

  const [error, setError] = useState<string>();

  const handleLogin: SubmitHandler<PostRequest> = async (request) => {
    try {
      const res = await apiLogin(request);
      setUser(res.data);
      router.push(ROUTE_PATHNAME.TOP);
    } catch (e) {
      if (axios.isAxiosError(e)) {
        const response = e.response!.data as ErrorResponse;
        const status = e.response!.status;

        if (status === 400) {
          setError(errorDictToString(response.data));
          return;
        }

        setError(response.message);
        return;
      }

      setError(ERROR_MESSAGE.UNKNOWN_ERROR);
      return;
    }
  };

  return (
    <form onSubmit={handleSubmit(handleLogin)} className={styles.form}>
      <Alert designType="error">{error}</Alert>

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
        require={false}
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
        require={false}
        error={errors?.password?.message}
      />

      <div>
        <DarkOrangeButton disabled={!isValid}>ログイン</DarkOrangeButton>
      </div>
    </form>
  );
};
