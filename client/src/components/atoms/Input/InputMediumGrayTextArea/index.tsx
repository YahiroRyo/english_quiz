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
  validation,
  placeholder,
}: Props) => {
  return (
    <textarea
      {...register(name, validation)}
      className={styles.input}
      placeholder={placeholder}
      rows={6}
    />
  );
};
