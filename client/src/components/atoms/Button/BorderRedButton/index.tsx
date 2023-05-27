import { ComponentProps } from "react";
import styles from "./index.module.scss";

type Props = ComponentProps<"button">;

export const BorderRedButton = ({
  type,
  children,
  disabled,
  onClick,
}: Props) => {
  return (
    <button
      className={styles.button}
      onClick={onClick}
      type={type}
      disabled={disabled}
    >
      {children}
    </button>
  );
};
