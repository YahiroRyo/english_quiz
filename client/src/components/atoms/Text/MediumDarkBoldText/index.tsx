import styles from "./index.module.scss";

type Props = {
  children?: React.ReactNode;
};

export const MediumDarkBoldText = ({ children }: Props) => {
  return <div className={styles.text}>{children}</div>;
};
