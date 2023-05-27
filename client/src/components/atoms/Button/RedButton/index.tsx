import { ComponentProps } from "react";
import styles from "./index.module.scss";

type Props = ComponentProps<"button">;

export const RedButton = ({ children, type, disabled, onClick }: Props) => {
  return (
    <button
      onClick={onClick}
      type={type}
      className={styles.button}
      disabled={disabled}
    >
      {children}
    </button>
  );
};
