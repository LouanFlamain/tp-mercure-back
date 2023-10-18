import { selectUser } from "../redux/userSlice";
import { useSelector } from "react-redux/es/hooks/useSelector";

const SearchUserCard = ({ props, data, addUser }) => {
  const user = useSelector(selectUser);

  const createChatRoom = (id) => {
    const token = localStorage.getItem("token");
    const req = { intervenant: [user.id, id] };
    fetch("http://localhost:9000/api/create_chat", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      credentials: "include",
      body: JSON.stringify(req),
    })
      .then((response) => response.json())
      .then((result) => {
        addUser(false);
      });
  };
  return (
    <div className="card w-96 h-96 bg-dark shadow-xl">
      <div className="card-body">
        <input
          onChange={(e) => props(e.target.value)}
          type="text"
          placeholder="Type here"
          className="input input-bordered w-full max-w-xs mb-3"
        />
        <ul className="max-h-64 overflow-scroll">
          {data.map((value, index) => {
            return (
              <li
                key={index}
                className="w-full my-2 bg-darker py-2 px-4 rounded-lg border-1 border-clear flex items-center cursor-pointer hover:text-clear"
                onClick={() => createChatRoom(value.id)}
              >
                <img
                  src={`/pp/${value.image}.jpeg` || `/pp/${value.image}.png`}
                  alt="profile picture"
                  className="rounded-full w-10 mr-4"
                />
                <p>{value.username}</p>
              </li>
            );
          })}
        </ul>
      </div>
    </div>
  );
};
export default SearchUserCard;
