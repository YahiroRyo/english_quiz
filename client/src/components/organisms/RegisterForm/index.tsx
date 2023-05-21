import { useForm } from "react-hook-form";
import styles from "./index.module.scss";
import { InputTextGroup } from "@/components/molecures/InputTextGroup";
import { DarkOrangeButton } from "@/components/atoms/Button/DarkOrangeButton";

export const RegisterForm = () => {
  const {
    register,
    handleSubmit,
    formState: { errors, isValid },
  } = useForm<{ username: string; password: string }>();

  const handleLogin = () => {};

  return (
    <form onSubmit={handleSubmit(handleLogin)} className={styles.form}>
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
        error={errors?.password?.message}
      />

      <div>
        <DarkOrangeButton disabled={!isValid}>ログイン</DarkOrangeButton>
      </div>
    </form>
  );
};
