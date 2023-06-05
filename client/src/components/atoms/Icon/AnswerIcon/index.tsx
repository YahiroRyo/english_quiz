import { faA } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import styles from "./index.module.scss";

export const AnswerIcon = () => {
  return (
    <div className={styles.icon}>
      <FontAwesomeIcon size="2x" icon={faA} />
    </div>
  );
};
