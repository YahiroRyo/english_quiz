import { ComponentProps } from "react";
import { UseFormRegister } from "react-hook-form";
import styles from "./index.module.scss";

type Props = {
  register: UseFormRegister<any>;
  name: string;
  validation: { [key: string]: any };
} & ComponentProps<"input">;

export const InputMediumGrayText = ({
  register,
  name,
  validation,
  placeholder,
  type,
}: Props) => {
  return (
    <input
      {...register(name, validation)}
      type={type}
      className={styles.input}
      placeholder={placeholder}
    />
  );
};
