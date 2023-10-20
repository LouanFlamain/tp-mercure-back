import { useState } from "react";
import { useSelector } from "react-redux";
import { selectUser } from "../redux/userSlice";

const GroupSearchBar = ({ selector }) => {
  const [inputValue, setInputValue] = useState("");
  const token = localStorage.getItem("token");
  const userSelector = useSelector(selectUser);

  const handleSubmit = (e) => {
    e.preventDefault();
    const req = {
      chat_id: selector.id,
      user_id: userSelector.id,
      message: inputValue,
    };

    fetch("http://localhost:9000/api/create_message", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      credentials: "include",
      body: JSON.stringify(req),
    })
      .then((response) => response.json())
      .then((results) => {
        console.log(results);
        if (results.success) {
          setInputValue("");
        }
      });
  };
  return (
    <div className="w-full bg-dark h-24 flex items-center px-10 rounded-br-2xl">
      <form onSubmit={handleSubmit} className="w-full flex">
        <input
          type="text"
          placeholder="Écrivez votre message ici"
          className="input input-bordered w-full mr-4"
          value={inputValue}
          onChange={(e) => {
            setInputValue(e.target.value);
          }}
        />
        <button type="submit" className="btn">
          Envoyer
        </button>
      </form>
    </div>
  );
};
export default GroupSearchBar;
