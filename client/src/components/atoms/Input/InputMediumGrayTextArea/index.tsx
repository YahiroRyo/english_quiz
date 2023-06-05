import { ComponentProps } from "react";
import { UseFormRegister } from "react-hook-form";
import styles from "./index.module.scss";

type Props = {
  register: UseFormRegister<any>;
  name: string;
  validation: { [key: string]: any };
} & ComponentProps<"textarea">;

export const InputMediumGrayTextArea = ({
  register,
  name,
  disabled,
  validation,
  placeholder,
  children,
}: Props) => {
  return (
    <textarea
      {...register(name, validation)}
      disabled={disabled}
      className={styles.input}
      placeholder={placeholder}
      rows={6}
    >
      {children}
    </textarea>
  );
};
